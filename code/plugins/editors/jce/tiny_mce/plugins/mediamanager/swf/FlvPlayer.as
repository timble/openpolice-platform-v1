/* 
* @copyright Copyright (C) 2007-2008 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
class FlvPlayer {
	//Objects
	private var nc:NetConnection;
	private var ns:NetStream;
	private var audio:Sound;
	private var movie:String;
	private var stageListener:Object = new Object();
	private var mouseListener:Object = new Object();
	//Interval Ids
	private var loadInt:Number;
	private var playInt:Number;
	private var scrubInt:Number;
	private var volumeInt:Number;
	private var bufferInt:Number;
	private var mouseInt:Number;
	// Numbers
	private var videoTime:Number;
	private var progressBarWidth:Number;
	private var defaultVolume:Number = 100;
	private var ow:Number;
	private var oh:Number;
	//Booleans
	private var isLoaded:Boolean = false;
	private var isPaused:Boolean = true;
	private var isMuted:Boolean = false;
	private var isFullscreen:Boolean = false;
	//Other
	private var baseUrl:String = 'plugins/editors/jce/tiny_mce/plugins/mediamanager/swf/';
	private var timeFormat:String = 'up';
	//External Configuration variables
	private var options:Object = {file:"playlist.xml", backcolor:0x999999, frontcolor:0x333333, lightcolor:0x999999, screencolor:0x000000, bufferlength:5, image:false, autostart:false, repeat:false};
	//Constructor
	public function FlvPlayer() {
		//Setup config variables
		for (var n in this.options) {
			if (_root[n] != undefined) {
				this.options[n] = _root[n];
				if (this.options[n] == 'true' || this.options[n] == '1') {
					this.options[n] = true;
				}
				if (this.options[n] == 'false' || this.options[n] == '0') {
					this.options[n] = false;
				}
			}
		}
		initPlayer();
	}
	private function initPlayer() {
		//Setup video connections
		this.nc = new NetConnection();
		this.nc.connect(null);
		this.ns = new NetStream(this.nc);
		this.ns.setBufferTime(this.options.bufferlength);

		this.ow = Stage.width;
		this.oh = Stage.height-16;

		_root.videoContainer.smoothing = true;
		_root.videoContainer.attachVideo(this.ns);

		var imageLoader:MovieClip = _root.createEmptyMovieClip("imageLoader", _root.videoBackground.getDepth()+1);
		if (this.checkVersion(9)) {
			_root.imageLoader.forceSmoothing = true;
		}
		if (this.options.image && !this.options.autostart) {
			_root.imageLoader.loadMovie(this.makeFile(this.options.image));
		}

		this.buildPlayer(false);
		_root.controller.lft.progressPlay._width = 0;
		_root.controller.lft.progressLoad._width = 0;

		_root.spinner._visible = false;
		_root.infoTxt._visible = false;

		//Set button states
		this.setPlay(true);
		_root.controller.rt.timeTxt.text = '00:00';

		this.setColors();
		this.initSound();
		this.parseFile();

		var self = this;
		this.ns.onMetaData = function(object:Object) {
			self.videoTime = object.duration;
		};
		this.ns.onStatus = function(obj:Object) {
			switch (obj.code) {
				case "NetStream.Play.Stop" :
					self.ns.seek(0.01);
					_root.controller.lft.progressPlay._width = 0;
					if (self.options.repeat) {
						self.playVideo();
					} else {
						self.pauseVideo();
					}
					_root.controller.rt.timeTxt.text = '00:00';
					break;
				case "NetStream.Play.Start" :
					this.setPlay(false);
					_root.spinner._visible = true;
					break;
				case "NetStream.Play.StreamNotFound" :
					self.setText("Unable to load file");
					break;
				case "NetStream.Buffer.Flush" :
				case "NetStream.Buffer.Full" :
					_root.spinner._visible = false;
					break;
				case "NetStream.Buffer.Empty" :
					_root.spinner._visible = true;
					this.setPlay(false);
					break;
			}
		};
		_root.videoBackground.onPress = function() {
			if (self.isPaused) {
				self.playVideo();
			} else {
				self.pauseVideo();
			}
		};
		_root.bigPlay.onPress = function() {
			self.playVideo();
		};
		_root.controller.lft.playBar.onPress = function() {
			if (self.isPaused) {
				self.playVideo();
			} else {
				self.pauseVideo();
			}
		};
		_root.controller.rt.muteBar.onPress = function() {
			self.muteVideo();
		};
		_root.controller.rt.timeBar.onPress = function() {
			self.timeFormat = self.timeFormat == 'up' ? 'down' : 'up';
			self.updateTime();
		};
		_root.controller.lft.progressLoad.onPress = function() {
			self.scrubInt = setInterval(self, 'scrubVideo', 10);
		};
		_root.controller.lft.progressLoad.onRelease = _root.controller.lft.progressLoad.onReleaseOutside=function () {
			clearInterval(self.scrubInt);
		};
		_root.controller.rt.volBar.onPress = function() {
			self.volumeInt = setInterval(self, 'setVideoVolume', 10);
		};
		_root.controller.rt.volBar.onRelease = _root.controller.rt.volBar.onReleaseOutside=function () {
			clearInterval(self.volumeInt);
		};

		if (this.checkVersion() >= 9) {
			Stage["displayState"] = "normal";

			_root.controller.rt.fullscreenBar.onPress = function() {
				Stage["displayState"] = Stage["displayState"] == "fullScreen" ? "normal" : "fullScreen";
			};
			stageListener.onFullScreen = function(fs:Boolean) {
				self.buildPlayer(fs);
			};
			Stage.addListener(stageListener);
		} else {
			this.setColor(_root.controller.rt.fullscreenBtn,this.options.lightcolor);
			_root.controller.rt.fullscreenBar.onRollOver = function() {
				self.setText('Fullscreen mode requires Flash Player 9.0.28+');
			};
			_root.controller.rt.fullscreenBar.onRollOut = function() {
				self.setText('');
			};
		}

		if (this.options.autostart) {
			this.playVideo();
		}
	}
	private function buildPlayer(fs:Boolean) {
		var self = this;
		var sw:Number = Stage.width;
		var sh:Number = Stage.height;

		var w:Number = fs ? sw*0.9 : sw;
		var h:Number = fs ? sh : sh-16;

		var y_pos:Number = fs ? h-h*0.1 : h;

		var x_pos_lft:Number = fs ? sw*0.05 : 0;
		var x_pos_rt:Number = sw-x_pos_lft;

		var vw = sw;
		var vh = h;

		_root.videoContainer._x = 0;
		_root.videoContainer._y = 0;

		if (fs) {
			var dim = this.getVideoDimensions();
			vw = dim['width'];
			vh = dim['height'];

			_root.videoContainer._x = (sw-vw)/2;
			_root.videoContainer._y = (sh-vh)/2;
		}
		//Video Container        
		_root.videoContainer._width = vw;
		_root.videoContainer._height = vh;
		//VideoBg
		_root.videoBackground._width = sw;
		_root.videoBackground._height = h;
		// Image Loader
		_root.onEnterFrame = function() {
			if (_root.imageLoader && _root.imageLoader._width>0) {
				delete _root.onEnterFrame;
				_root.imageLoader._width = sw;
				_root.imageLoader._height = h;
			}
		};
		// Controller
		_root.controller.bg._width = w;
		_root.controller._y = y_pos;

		if (fs) {
			mouseInt = setInterval(this, 'hideController', 5000);
			mouseListener.onMouseMove = function() {
				_root.controller._visible = true;
				Mouse.show();
			};
			Mouse.addListener(mouseListener);
		} else {
			clearInterval(mouseInt);
			_root.controller._visible = true;
			Mouse.show();
			Mouse.removeListener(mouseListener);
		}

		_root.controller._x = x_pos_lft;
		_root.controller.rt._x = _root.controller.bg._width;

		//Progress Bars
		var lb:Number = w-(_root.controller.rt._width+_root.controller.lft._width-_root.controller.lft.loadBar._width);
		_root.controller.lft.loadBar._width = lb;
		_root.controller.loadEdge._width = lb;

		this.progressBarWidth = lb-4;

		this.updateLoadProgress();
		this.updatePlayProgress();

		var hsw:Number = sw/2;
		var hsh:Number = h/2;

		//Text  
		_root.infoTxt._x = hsw-_root.infoTxt._width/2;
		_root.infoTxt._y = hsh-_root.infoTxt._height/2+_root.bigPlay._height;
		//Big Play
		_root.bigPlay._x = hsw-_root.bigPlay._width/2;
		_root.bigPlay._y = hsh-_root.bigPlay._height/2;
		//Spinner
		_root.spinner._x = hsw-_root.spinner._width/2;
		_root.spinner._y = hsh-_root.spinner._height/2;

		// Update color...
		this.setColor(_root.controller.rt.fullscreenBtn,this.options.frontcolor);
	}
	private function setColors() {
		var self = this;
		// Play button
		this.setColor(_root.controller.lft.playBtn,this.options.frontcolor);
		_root.controller.lft.playBar.onRollOver = function() {
			self.setColor(_root.controller.lft.playBtn,self.options.lightcolor);
			self.setColor(_root.controller.lft.pauseBtn,self.options.lightcolor);
		};
		_root.controller.lft.playBar.onRollOut = function() {
			self.setColor(_root.controller.lft.playBtn,self.options.frontcolor);
			self.setColor(_root.controller.lft.pauseBtn,self.options.frontcolor);
		};
		// Pause button
		this.setColor(_root.controller.lft.pauseBtn,this.options.frontcolor);

		// Fullscreen button
		_root.controller.rt.fullscreenBar.onRollOver = function() {
			self.setColor(_root.controller.rt.fullscreenBtn,self.options.lightcolor);
		};
		_root.controller.rt.fullscreenBar.onRollOut = function() {
			self.setColor(_root.controller.rt.fullscreenBtn,self.options.frontcolor);
		};
		// Mute Button
		this.setColor(_root.controller.rt.muteBtn,this.options.frontcolor);
		_root.controller.rt.muteBar.onRollOver = function() {
			self.setColor(_root.controller.rt.muteBtn,self.options.lightcolor);
		};
		_root.controller.rt.muteBar.onRollOut = function() {
			self.setColor(_root.controller.rt.muteBtn,self.options.frontcolor);
		};

		this.setColor(_root.controller.rt.volumeBtn.drag,this.options.frontcolor);
		this.setColor(_root.controller.lft.progressPlay,this.options.frontcolor);
		this.setColor(_root.controller.lft.progressLoad,this.options.lightcolor);
		this.setColor(_root.controller.rt.volumeBtn.hit,this.options.lightcolor);

		this.setColor(_root.controller.bg,this.options.backcolor);
		this.setColor(_root.controller.rt.edge,this.options.frontcolor);
		this.setColor(_root.controller.lft.edge,this.options.frontcolor);
		this.setColor(_root.controller.loadEdge,this.options.frontcolor);

		this.setColor(_root.videoBackground,this.options.screencolor);

		// Time
		_root.controller.rt.timeTxt.textColor = this.options.frontcolor;
		_root.controller.rt.timeBar.onRollOver = function() {
			_root.controller.rt.timeTxt.textColor = self.options.lightcolor;
		};
		_root.controller.rt.timeBar.onRollOut = function() {
			_root.controller.rt.timeTxt.textColor = self.options.frontcolor;
		};
	}
	private function hideController() {
		if (_root.controller.hitTest(_root._xmouse, _root._ymouse, true)) {
			return false;
		}
		_root.controller._visible = false;
		Mouse.hide();
	}
	private function initSound() {
		_root.createEmptyMovieClip("videoSound",_root.getNextHighestDepth());
		_root.videoSound.attachAudio(this.ns);
		this.audio = new Sound(_root.videoSound);
		this.audio.setVolume(100);
	}
	private function playVideo() {
		if (!this.isLoaded) {
			return false;
		}
		if (this.ns.bufferLength<this.ns.bufferTime) {
			_root.spinner._visible = true;
		} else {
			_root.spinner._visible = false;
		}
		this.isPaused = false;
		this.setPlay(false);
		
		if (this.ns.bytesLoaded == 0) {
			if (this.movie != undefined) {
				this.ns.play(this.makeFile(this.movie));
			} else {
				_root.infoText.text = "No file specified";
				this.setPlay(true);
			}
			if (this.isMuted) {
				this.audio.setVolume(0);
				_root.controller.rt.volumeBtn.drag._xscale = 0;
			} else {
				this.audio.setVolume(this.defaultVolume);
				_root.controller.rt.volumeBtn.drag._xscale = this.defaultVolume;
			}
			this.loadInt = setInterval(this, 'updateLoadProgress', 10);
		} else {
			this.ns.pause(false);
		}
		this.playInt = setInterval(this, 'updatePlayProgress', 10);
	}
	private function setPlay(st:Boolean):Void {
		_root.controller.lft.pauseBtn._visible = !st;
		_root.controller.lft.playBtn._visible = st;
		_root.bigPlay._visible = st;
	}
	private function pauseVideo():Void {
		this.isPaused = true;
		this.setPlay(true);
		this.ns.pause();
		clearInterval(this.playInt);
		_root.spinner._visible = false;
	}
	private function muteVideo() {
		if (this.isMuted) {
			this.audio.setVolume(this.defaultVolume);
			_root.controller.rt.volumeBtn.drag._xscale = this.defaultVolume;
			this.isMuted = false;
		} else if (!this.isMuted) {
			this.audio.setVolume(0);
			_root.controller.rt.volumeBtn.drag._xscale = 0;
			this.isMuted = true;
		}
	}
	function setVideoVolume() {
		var v:Number = _root.controller.rt.volumeBtn.hit._width;
		var n:Number = _root.controller.rt.volumeBtn._xmouse/v*100;
		if (n>100) {
			n = 100;
		}
		if (n<0) {
			n = 0;
		}
		_root.controller.rt.volumeBtn.drag._width = v*n/100;
		this.defaultVolume = n;
		this.audio.setVolume(n);
	}
	function scrubVideo() {
		var pl:MovieClip = _root.controller.lft.progressLoad;
		var xMouse:Number = pl._xmouse*pl._width/2;
		if (xMouse>pl._width) {
			xMouse = pl._width;
		}
		if (xMouse<0) {
			xMouse = 0;
		}
		_root.controller.lft.progressPlay._width = xMouse;
		var pct:Number = xMouse/pl._width*100;
		var pos:Number = this.videoTime/100*pct;
		this.ns.seek(pos);
		this.updateTime(pos);
	}
	private function updatePlayProgress() {
		_root.controller.lft.progressPlay._width = this.ns.time/this.videoTime*this.progressBarWidth;
		this.updateTime();
	}
	private function updateTime(time:Number) {
		if (!time) {
			time = this.ns.time;
		}
		if (this.timeFormat == 'down') {
			time = this.videoTime-time;
		}
		if (isNaN(time)) {
			time = 0;
		}
		var minutes = Math.floor(time/60);
		var seconds = Math.floor(time%60);

		if (minutes<10) {
			minutes = "0"+minutes;
		}
		if (seconds<10) {
			seconds = "0"+seconds;
		}
		_root.controller.rt.timeTxt.text = minutes+":"+seconds;
	}
	private function updateLoadProgress() {
		var p:Number = this.ns.bytesLoaded/this.ns.bytesTotal*this.progressBarWidth;
		_root.controller.lft.progressLoad._width = p;
		if (p>=this.progressBarWidth) {
			clearInterval(this.loadInt);
		}
	}
	//Auxilary functions
	private function parseFile() {
		var src:String = this.options.file;
		this.setPlay(true);
		_root.spinner._visible = true;
		var self = this;
		if (this.getExtension(src) == 'xml') {
			var playlist:XML = new XML();
			playlist.ignoreWhite = true;
			playlist.load(this.makeFile(src));
			playlist.onLoad = function(success) {
				if (success) {
					_root.spinner._visible = false;
					this.setPlay(true);
					self.isLoaded = true;
					var tracklist = playlist.firstChild.childNodes;
					var track = tracklist[0].firstChild.childNodes;
					for (var i = 0; i<track.length; i++) {
						if (track[i].nodeName == 'location') {
							self.movie = track[i].firstChild;
						}
					}
				} else {
					_root.spinner._visible = false;
					self.setText("Unable to load file!");
				}
			};
		} else {
			this.movie = src;
			this.isLoaded = true;
			this.setPlay(true);
			_root.spinner._visible = false;
		}
	}
	private function makeFile(url:String) {
		if (url.indexOf('://') == -1) {
			url = this.getUrl()+url;
		}
		return url;
	}
	private function getUrl() {
		var url = _root._url;
		url = url.substring(0, url.lastIndexOf(this.baseUrl));
		return url;
	}
	private function checkVersion() {
		var v:String = getVersion();
		var n:Array = v.split(",");
		var s:String = n.join(".");
		var m:Number = parseInt(s);

		return m;
	}
	private function getExtension(file:String) {
		var arr:Array = file.split('.');
		var ext:String = arr[arr.length-1];
		return ext.toLowerCase();
	}
	private function setColor(mc:MovieClip, col:Number) {
		var color:Color = new Color(mc);
		color.setRGB(col);
	}
	private function getVideoDimensions() {
		var sw = Stage.width;
		var sh = Stage.height;

		var w = this.ow;
		var h = this.oh;

		if (w>h) {
			h = h*(sw/w);
			w = sw;
			if (h>sh) {
				w = w*(sh/h);
				h = sh;
			}
		} else {
			w = w*(sh/h);
			h = sh;
			if (w>sw) {
				h = h*(sw/w);
				w = sw;
			}
		}
		w = Math.round(w);
		h = Math.round(h);

		var dim:Object = {width:w, height:h};
		return dim;
	}
	private function setText(txt:String) {
		_root.infoTxt._visible = txt.length;
		_root.infoTxt.txt.text = txt;
	}
}