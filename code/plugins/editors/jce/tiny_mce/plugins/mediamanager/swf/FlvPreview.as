/* 
* @copyright Copyright (C) 2007-2008 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
class FlvPreview {
	//Other
	private var baseUrl:String = 'plugins/editors/jce/tiny_mce/plugins/mediamanager/swf/';
	//External Configuration variables
	private var options:Object = {backcolor:0x999999, frontcolor:0x333333, lightcolor:0x999999, screencolor:0x000000, image:false};
	//Constructor
	public function FlvPreview() {
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
		var imageLoader:MovieClip = _root.createEmptyMovieClip("imageLoader", _root.videoBackground.getDepth() + 1);
		if (this.options.image && !this.options.autostart) {
			_root.imageLoader.loadMovie(this.makeFile(this.options.image));
		}
		this.buildPlayer();
	}
	private function buildPlayer() {
		//Set button states
		var self = this;
		_root.playBtn._visible = true;
		
		//Set Colors
		this.setColor(_root.playBtn,this.options.frontcolor);
		this.setColor(_root.muteBtn,this.options.frontcolor);
		this.setColor(_root.fullscreenBtn,this.options.frontcolor);
		
		// Play button
		_root.playBtn.onRollOver = function(){
			self.setColor(this, self.options.lightcolor);
		}
		_root.playBtn.onRollOut = function(){
			self.setColor(this, self.options.frontcolor);
		}
		
		// Fullscreen button
		_root.fullscreenBtn.onRollOver = function(){
			self.setColor(this, self.options.lightcolor);
		}
		_root.fullscreenBtn.onRollOut = function(){
			self.setColor(this, self.options.frontcolor);
		}
		// Mute Button
		_root.muteBtn.onRollOver = function(){
			self.setColor(this, self.options.lightcolor);
		}
		_root.muteBtn.onRollOut = function(){
			self.setColor(this, self.options.frontcolor);
		}		
		
		this.setColor(_root.volumeBtn.dark,this.options.frontcolor);
		this.setColor(_root.progressPlay,this.options.frontcolor);
		this.setColor(_root.progressLoad,this.options.lightcolor);
		this.setColor(_root.volumeBtn.light,this.options.lightcolor);
		this.setColor(_root.controllerBg,this.options.backcolor);
		this.setColor(_root.controllerEdge,this.options.frontcolor);
		this.setColor(_root.videoBackground,this.options.screencolor);
		
		_root.timeTxt.textColor = this.options.frontcolor;

		_root.timeBar.onRollOver = function(){
			_root.timeTxt.textColor = self.options.lightcolor;
		}
		_root.timeBar.onRollOut = function(){
			_root.timeTxt.textColor = self.options.frontcolor;
		}
		
		// Image Loader
		_root.onEnterFrame = function (){
			if (_root.imageLoader && _root.imageLoader._width > 0){
				delete _root.onEnterFrame;
				_root.imageLoader._width = Stage.width;
				_root.imageLoader._height = Stage.height - 16;
			}
		}
	}
	private function makeFile(url:String) {
		if(url.indexOf('://') == -1){
			url = this.getUrl() + url;
		}
		return url;
	}
	private function getUrl() {
		var url = _root._url;
		url = url.substring(0, url.lastIndexOf(this.baseUrl));
		return url;
	}
	private function setColor(mc:MovieClip, col:Number) {
		var color:Color = new Color(mc);
		color.setRGB(col);
	}
}