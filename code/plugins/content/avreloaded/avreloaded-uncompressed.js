/*! $Id: avreloaded-uncompressed.js 994 2008-06-27 03:55:33Z Fritz Elfert $ */

if (typeof(allvideos) == 'undefined') {
    var allvideos = new Object();
    // Holds all scriptable player instances
    allvideos.APIs = new Array();
}


// Callback function (called from the player)
function getUpdate(typ, pr1, pr2, pid) {
    if (pid == 'null')
        return;
    allvideos.APIs.each(function(obj) {
        if (obj._pid == pid) {
            obj._plCB(typ, pr1, pr2);
        }
    });
}

allvideos.API = function(id) {
    var ret = null;
    allvideos.APIs.each(function(obj) {
        if (obj._pid == id) {
            ret = obj;
        }
    });
    if (ret != null) {
        return ret;
    }

    this._pid = id;
    this._player = null;
    this._item = null;
    this._load = null;
    this._width = null;
    this._height = null;
    this._state = null;
    this._elapsed = null;
    this._remaining = null;
    this._volume = null;

    // Callback function (called from the player)
    this._plCB = function(typ, pr1, pr2) {
        switch (typ) {
            case 'item':
                this._item = pr1;
                break;
            case 'load':
                this._load = pr1;
                break;
            case 'size':
                this._width = pr1;
                this._height = pr2;
                break;
            case 'state':
                this._state = pr1;
                break;
            case 'time':
                this._elapsed = pr1;
                this._remaining = pr2;
                break;
            case 'volume':
                this._volume = pr1;
                break;
        }
    };

    this.p = function() {
        if (this._player == null) {
            if(navigator.appName.indexOf("Microsoft") != -1) {
                this._player = window[this._pid];
            } else {
                this._player = document[this._pid];
            }
        }
        return this._player;
    };

    this.sendEvent = function(typ, prm) {
        this.p().sendEvent(typ, prm);
    };

    this.loadFile = function(obj) {
        this.p().loadFile(obj);
    };

    this.addItem = function(obj, idx) {
        this.p().addItem(obj,idx);
    };

    this.removeItem = function(idx) {
        this.p().removeItem(idx);
    };

    this.togglePause = function() {
        this.sendEvent('playpause');
    };

    this.next = function() {
        this.sendEvent('next');
    };

    this.prev = function() {
        this.sendEvent('prev');
    };

    this.scrub = function(val) {
        this.sendEvent('scrub', (this._elapsed ? this._elapsed : 0)  + val);
    };

    this.volume = function(val) {
        this.sendEvent('volume', (this._volume ? this._volume : 0) + val);
    };

    this.getLength = function() {
        return this.p().getLength();
    };

    this.navItem = function(val) {
            this.sendEvent('getlink', (val == null) ? 0 : val);
    };

    this.play = function(val) {
        this.sendEvent('playitem', (val == null) ? 0 : val);
    };

    this.stop = function() {
        this.sendEvent('stop');
    };

    allvideos.APIs.push(this);
};

function AvrPopup(e, id, type) {
    new Event(e).stop();
    var v = $('avrpopup_'+id);
    if (v) {
        if (!type) {
            type = 'lightbox';
        }
        var opts = Json.evaluate(v.getProperty('title'));
        if (type == 'lightbox') {
            opts.url = decodeURIComponent(opts.url);
            if (typeof(window.opera) != 'undefined') {
                opts.size.y += 4;
            }
            opts.onClose = function() {
                var f = $$('#sbox-content iframe'); // id='sbox-content'
                if (f && (f.length > 0)) {
                    f[0].src = 'about:blank';
                }
            };
            SqueezeBox.fromElement(v, opts);
        } else {
            var w = window.open(decodeURIComponent(opts.url),
                    'avrpopup'+id,'status=no,toolbar=no,'+
                    'scrollbars=no,titlebar=no,menubar=no,resizable=no,width='+
                    opts.size.x+',height='+opts.size.y+',directories=no,location=no');
            w.focus();
        }
    }
}

/*
function AvrMouseoverPlay(id) {
    this._id = 'p_'+id;
    this._api = new allvideos.API(this._id);
    this._inside = false;

    this.doMouseMove = function(e) {
        var c = $(this._id).getCoordinates();
        c.left -= 5;
        c.right += 5;
        c.top -= 5;
        c.bottom = c.top + c.height + 10;
        var last = this._inside;
        this._inside = (
                (e.clientX >= c.left) && (e.clientX <= c.right) &&
                (e.clientY >= c.top) && (e.clientY <= c.bottom)   );
        if (last != this._inside) {
            this._api.togglePause();
            //if (this._inside) {
                //this._api.play(0);
            //} else {
                //this._api.stop();
            //}
        }
    }
    document.onmousemove = this.doMouseMove.bindAsEventListener(this);
}
*/
