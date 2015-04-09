tinyMCEPopup.requireLangPack();

var FileSelectDialog = {
	preInit : function() {
		var url;

		tinyMCEPopup.requireLangPack();

		if (url = tinyMCEPopup.getParam("external_file_list_url"))
			document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');
	},

	init : function(ed) {
		var f = document.forms[0], nl = f.elements, ed = tinyMCEPopup.editor, dom = ed.dom, n = ed.selection.getNode();

                this.fillFileList('src_list', 'tinyMCEFileList');

		tinyMCEPopup.resizeToInnerSize();
                
                if (n.nodeName == 'A') {
			nl.href.value = dom.getAttrib(n, 'href');
			nl.title.value = dom.get(n).innerHTML;
		
                        selectByValue(f, 'src_list', dom.getAttrib(n, 'href'));

			nl.id.value = dom.getAttrib(n, 'id');
			nl.lang.value = dom.getAttrib(n, 'lang');
			nl.insert.value = ed.getLang('update');

		}

		TinyMCE_EditableSelects.init();

		// Setup browse button
		document.getElementById('hrefbrowsercontainer').innerHTML = getBrowserHTML('hrefbrowser','href','image','theme_advanced_image');
		if (isVisible('srcbrowser'))
			document.getElementById('href').style.width = '260px';

		// Setup browse button
		document.getElementById('onmouseoversrccontainer').innerHTML = getBrowserHTML('overbrowser','onmouseoversrc','image','theme_advanced_image');
		if (isVisible('overbrowser'))
			document.getElementById('onmouseoversrc').style.width = '260px';

		// Setup browse button
		document.getElementById('onmouseoutsrccontainer').innerHTML = getBrowserHTML('outbrowser','onmouseoutsrc','image','theme_advanced_image');
		if (isVisible('outbrowser'))
			document.getElementById('onmouseoutsrc').style.width = '260px';


		this.changeAppearance();
	},

	insert : function(file, title) {
		var ed = tinyMCEPopup.editor, t = this, f = document.forms[0];

		if (f.href.value === '') {
			if (ed.selection.getNode().nodeName == 'A') {
				ed.dom.remove(ed.selection.getNode());
				ed.execCommand('mceRepaint');
			}

			tinyMCEPopup.close();
			return;
		}

		if (tinyMCEPopup.getParam("accessibility_warnings", 1)) {
			if (!f.title.value) {
				tinyMCEPopup.confirm(tinyMCEPopup.getLang('fgfileselect_dlg.missing_title'), function(s) {
					if (s)
						t.insertAndClose();
				});

				return;
			}
		}

		t.insertAndClose();
	},

	insertAndClose : function() {
		var ed = tinyMCEPopup.editor, f = document.forms[0], nl = f.elements, v, args = {}, el;

		tinyMCEPopup.restoreSelection();

		// Fixes crash in Safari
		if (tinymce.isWebKit)
			ed.getWin().focus();

		tinymce.extend(args, {
			href : nl.href.value,
			title : nl.title.value
		});

		el = ed.selection.getNode();

		if (el && el.nodeName == 'A') 
                {
			ed.dom.setAttrib(el,'href', args.href);
                        ed.dom.set(el,args.title);
		} else {
			ed.execCommand('mceInsertContent', false, '<a id="__mce_tmp">'+args.title+'</a>', {skip_undo : 1});
			ed.dom.setAttrib('__mce_tmp', 'href',args.href);
                        ed.dom.setAttrib('__mce_tmp', 'id', '');
                        
			ed.undoManager.add();
		}

		tinyMCEPopup.close();
	},

	getAttrib : function(e, at) {
		var ed = tinyMCEPopup.editor, dom = ed.dom, v, v2;

		if (v = dom.getAttrib(e, at))
			return v;

		return '';
	},


	fillFileList : function(id, l) {
		var dom = tinyMCEPopup.dom, lst = dom.get(id), v, cl;

		l = window[l];
		lst.options.length = 0;

		if (l && l.length > 0) {
			lst.options[lst.options.length] = new Option('', '');

			tinymce.each(l, function(o) {
				lst.options[lst.options.length] = new Option(o[0], o[1]);
			});
		} else
			dom.remove(dom.getParent(id, 'tr'));
	}
};

FileSelectDialog.preInit();
tinyMCEPopup.onInit.add(FileSelectDialog.init, FileSelectDialog);
