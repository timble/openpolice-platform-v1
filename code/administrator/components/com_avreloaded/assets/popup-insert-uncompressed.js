/*!	$Id: popup-insert-uncompressed.js 989 2008-06-25 19:02:32Z Fritz Elfert $ */
function AvReloadedInsert() {

	this.init = function(tags,ltags,w,h,havepv) {
		o = this._getUriObject(window.self.location.href);
		q = $H(this._getQueryObject(o.query));
		this.editor = decodeURIComponent(q.get('e_name'));
        pl = q.get('playlist');
		this.playlist = pl ? decodeURIComponent(pl) : 0;
        this.form = $("adminForm");

		// Setup fields object
		this.fields = new Object();
		this.fields.url       = $("url");
		this.fields.mloc      = $("mloc");
		this.fields.provider  = $("provider");
		this.fields.lprovider = $("lprovider");
		this.fields.tagid     = $("tagid");
		this.fields.ltagid    = $("ltagid");
		this.fields.width     = $("width");
		this.fields.lwidth    = $("lwidth");
		this.fields.height    = $("height");
		this.fields.lheight   = $("lheight");
		this.fields.mtag      = $("mtag");
		this.fields.lmtag     = $("lmtag");
		this.fields.local     = $("local");

        this.buttons = [ $('pv'), $('ins') ];
        this.lbuttons = [ $('lpv'), $('lins') ];

        // Setup media tags
        this.tags = tags;
        this.ltags = ltags;

        // Setup default dimensions
		this.dim = new Object();
        this.dim.w = w;
        this.dim.h = h;

        if (!havepv) {
            $("preview").style['height'] = h+'px';
        }
        this.checkTag(0);
        this.checkTag(1);
	};

    this.buildTag = function(local, t) {
        if (local) {
            var w = this.fields.lwidth.getValue();
            var h = this.fields.lheight.getValue();
            var t = this.fields.ltagid.getValue();
            var p = this.fields.lprovider.getValue();

            for (var i = 0; i < this.ltags.length; i++) {
                if (this.ltags[i].val == p) {
                    var tagval = this.ltags[i].tag;
                    var v = '{'+tagval;
                    if ((w != '') && (w != this.dim.w)) {
                        v += ' width="'+w+'"';
                    }
                    if ((h != '') && (h != this.dim.h)) {
                        v += ' height="'+h+'"';
                    }
                    v += '}'+t+'{/'+tagval+'}';
                    this.fields.lmtag.value = v;
                    this.checkTag(local);
                    break;
                }
            }
        } else {
            var w = this.fields.width.getValue();
            var h = this.fields.height.getValue();
            var t = this.fields.tagid.getValue();
            var p = this.fields.provider.getValue();

            for (var i = 0; i < this.tags.length; i++) {
                if (this.tags[i].val == p) {
                    var tagval = this.tags[i].tag;
                    var v = '{'+tagval;
                    if ((w != '') && (w != this.dim.w)) {
                        v += ' width="'+w+'"';
                    }
                    if ((h != '') && (h != this.dim.h)) {
                        v += ' height="'+h+'"';
                    }
                    v += '}'+t+'{/'+tagval+'}';
                    this.fields.mtag.value = v;
                    this.checkTag(local);
                    break;
                }
            }
        }
        return false;
    };

    this.matchLOC = function(loc) {
        for (var i = 0; i < this.ltags.length; i++) {
            if (this.ltags[i].rx != null) {
                var result;
                if (result = this.ltags[i].rx.exec(loc)) {
                    this.fields.lprovider.value = this.ltags[i].val;
                    this.fields.ltagid.value = result[1];
                    this.buildTag(true);
                    break;
                }
            }
        }
        return false;
    };

    this.matchURL = function(url) {
        for (var i = 0; i < this.tags.length; i++) {
            if (this.tags[i].rx != null) {
                var result;
                if (result = this.tags[i].rx.exec(url)) {
                    this.fields.provider.value = this.tags[i].val;
                    this.fields.tagid.value = result[1];
                    this.buildTag(false);
                    break;
                }
            }
        }
        return false;
    };

    this.enable = function(local, on) {
        var btns = local ? this.lbuttons : this.buttons;
        btns.each(function(b){b.disabled = !on;});
    };

    this.checkTag = function(local) {
        if (local) {
            var v = this.fields.lmtag.getValue();
            for (var i = 0; i < this.ltags.length; i++) {
                var t = this.ltags[i].tag;
                var rx = new RegExp('^{'+t+'.*}.+{/'+t+'}$');
                if (rx.test(v)) {
                    this.enable(local, true);
                    return true;
                }
            }
        } else {
            var v = this.fields.mtag.getValue();
            for (var i = 0; i < this.tags.length; i++) {
                var t = this.tags[i].tag;
                var rx = new RegExp('^{'+t+'.*}.+{/'+t+'}$');
                if (rx.test(v)) {
                    this.enable(local, true);
                    return true;
                }
            }
        }
        this.enable(local, false);
        return false;
    };

    this.onpreview = function(local) {
        if (this.checkTag(local)) {
            this.fields.local.value = local;
            this.form.submit();
        }
    };

    this.onok = function(local) {
        if (this.playlist) {
            var uri = (local) ? 'local:'+this.fields.mloc.getValue() : this.fields.url.getValue();
            window.parent.plinsert(uri);
        } else {
            var tag = (local) ? this.fields.lmtag.getValue() : this.fields.mtag.getValue();
            window.parent.jInsertEditorText(tag, this.editor);
        }
        return false;
    };

    this.showMessage = function(text) {
        var message  = $('message');
        var messages = $('messages');

        if (message.firstChild)
            message.removeChild(message.firstChild);

        message.appendChild(document.createTextNode(text));
        messages.style.display = "block";
    };

    this.parseQuery = function(query) {
        var params = new Object();
        if (!query) {
            return params;
        }
        var pairs = query.split(/[;&]/);
        for ( var i = 0; i < pairs.length; i++ ) {
            var KeyVal = pairs[i].split('=');
            if ( ! KeyVal || KeyVal.length != 2 ) {
                continue;
            }
            var key = unescape( KeyVal[0] );
            var val = unescape( KeyVal[1] ).replace(/\+ /g, ' ');
            params[key] = val;
        }
        return params;
    };

    this._getQueryObject = function(q) {
        var vars = q.split(/[&;]/);
        var rs = {};
        if (vars.length) vars.each(function(val) {
                var keys = val.split('=');
                if (keys.length && keys.length == 2) rs[encodeURIComponent(keys[0])] = encodeURIComponent(keys[1]);
                });
        return rs;
    };

    this._getUriObject = function(u) {
        var bits = u.match(/^(?:([^:\/?#.]+):)?(?:\/\/)?(([^:\/?#]*)(?::(\d*))?)((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[\?#]|$)))*\/?)?([^?#\/]*))?(?:\?([^#]*))?(?:#(.*))?/);
        return (bits)
            ? bits.associate(['uri', 'scheme', 'authority', 'domain', 'port', 'path', 'directory', 'file', 'query', 'fragment'])
            : null;
    };
}
