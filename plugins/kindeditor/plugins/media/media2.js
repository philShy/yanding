/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('media', function(K) {
	var self = this, name = 'media', lang = self.lang(name + '.'),
	allowMediaUpload = K.undef(self.allowMediaUpload, true),
	allowFileManager = K.undef(self.allowFileManager, false),
	formatUploadUrl = K.undef(self.formatUploadUrl, true),
	uploadJson = K.undef(self.uploadJson, self.basePath + 'php/upload_json.php');
	filePostName = K.undef(self.filePostName, 'imgFile'),
	
	self.plugin.mediaDialog = function(options) {
		var mediaUrl = options.mediaUrl,
		mediaWidth = K.undef(options.mediaWidth, ''),
		mediaHeight = K.undef(options.mediaHeight, ''),
		showLocal = K.undef(options.showLocal, true),
		autostart = K.undef(options.autostart, '')
		clickFn = options.clickFn;
		var target = 'kindeditor_upload_iframe_' + new Date().getTime();
		var html = [
					'<div style="padding:20px;">',
					//url
					'<div class="ke-dialog-row">',
					'<label for="keUrl" style="width:60px;">' + lang.url + '</label>',
					'<input class="ke-input-text" type="text" id="keUrl" name="url" value="" style="width:160px;" /> &nbsp;',
					'<input type="button" class="ke-upload-button" value="' + lang.upload + '" /> &nbsp;',
					'<span class="ke-button-common ke-button-outer">',
					'<input type="button" class="ke-button-common ke-button" name="viewServer" value="' + lang.viewServer + '" />',
					'</span>',
					'</div>',
					//width
					'<div class="ke-dialog-row">',
					'<label for="keWidth" style="width:60px;">' + lang.width + '</label>',
					'<input type="text" id="keWidth" class="ke-input-text ke-input-number" name="width" value="550" maxlength="4" />',
					'</div>',
					//height
					'<div class="ke-dialog-row">',
					'<label for="keHeight" style="width:60px;">' + lang.height + '</label>',
					'<input type="text" id="keHeight" class="ke-input-text ke-input-number" name="height" value="400" maxlength="4" />',
					'</div>',
					//autostart
					'<div class="ke-dialog-row">',
					'<label for="keAutostart">' + lang.autostart + '</label>',
					'<input type="checkbox" id="keAutostart" name="autostart" value="" /> ',
					'</div>',
					'</div>'
				].join('');
		var dialogWidth = showLocal || allowFileManager ? 450 : 400,
			dialogHeight = showLocal ? 300 : 250;
		var dialog = self.createDialog({
			name : name,
			width : dialogWidth,
			height : dialogHeight,
			title : self.lang(name),
			body : html,
			yesBtn : {
				name : self.lang('yes'),
				click : function(e) {
					// insert remote image
					var url = K.trim(urlBox.val()),
						width = widthBox.val(),
						height = heightBox.val(),
						autostart = autostartBox[0].checked ? 'true' : 'false',	
						type = K.mediaType(url),		
					if (url == 'http://' || K.invalidUrl(url)) {
						alert(self.lang('invalidUrl'));
						urlBox[0].focus();
						return;
					}
					if (!/^\d*$/.test(width)) {
						alert(self.lang('invalidWidth'));
						widthBox[0].focus();
						return;
					}
					if (!/^\d*$/.test(height)) {
						alert(self.lang('invalidHeight'));
						heightBox[0].focus();
						return;
					}
					clickFn.call(self, url, width, height,autostart);
				}
			},
			beforeRemove : function() {
				viewServerBtn.unbind();
				widthBox.unbind();
				heightBox.unbind();
				autostartBox.unbind();
			}
		}),
		div = dialog.div;

		var urlBox = K('[name="url"]', div),
			viewServerBtn = K('[name="viewServer"]', div),
			widthBox = K('[name="width"]', div),
			heightBox = K('[name="height"]', div),
			autostartBox = K('[name="autostart"]', div);

		if (allowMediaUpload) {
			var uploadbutton = K.uploadbutton({
				button : K('.ke-upload-button', div)[0],
				fieldName : filePostName,
				url : K.addParam(uploadJson, 'dir=media'),
				afterUpload : function(data) {
					dialog.hideLoading();
					if (data.error === 0) {
						var url = data.url;
						if (formatUploadUrl) {
							url = K.formatUrl(url, 'absolute');
						}
						urlBox.val(url);
						if (self.afterUpload) {
							self.afterUpload.call(self, url, data, name);
						}
					} else {
						alert(data.message);
					}
				},
				afterError : function(html) {
					dialog.hideLoading();
					self.errorDialog(html);
				}
			});
			uploadbutton.fileBox.change(function(e) {
				localUrlBox.val(uploadbutton.fileBox.val());
			});
		} else {
			K('.ke-upload-button', div).hide();
		}
		if (allowFileManager) {
			viewServerBtn.click(function(e) {
				self.loadPlugin('filemanager', function() {
					self.plugin.filemanagerDialog({
						viewType : 'LIST',
						dirName : 'media',
						clickFn : function(url, title) {
							if (self.dialogs.length > 1) {
								K('[name="url"]', div).val(url);
								if (self.afterSelectFile) {
									self.afterSelectFile.call(self, url);
								}
								self.hideDialog();
							}
						}
					});
				});
			});
		} else {
			viewServerBtn.hide();
		}
		return dialog;
	};
	self.plugin.media = {
		edit : function() {
			var img = self.plugin.getSelectedMedia();
			self.plugin.imageDialog({
				imageUrl : img ? img.attr('data-ke-src') : 'http://',
				imageWidth : img ? img.width() : '',
				imageHeight : img ? img.height() : '',
				imageTitle : img ? img.attr('title') : '',
				imageAlign : img ? img.attr('align') : '',
				showRemote : allowImageRemote,
				showLocal : allowImageUpload,
				tabIndex: img ? 0 : imageTabIndex,
				clickFn : function(url, title, width, height, border, align) {
					if (img) {
						img.attr('src', url);
						img.attr('data-ke-src', url);
						img.attr('width', width);
						img.attr('height', height);
						img.attr('title', title);
						img.attr('align', align);
						img.attr('alt', title);
					} else {
						self.exec('insertimage', url, title, width, height, border, align);
					}
					// Bugfix: [Firefox] 上传图片后，总是出现正在加载的样式，需要延迟执行hideDialog
					setTimeout(function() {
						self.hideDialog().focus();
					}, 0);
				}
			});
		},
		'delete' : function() {
			self.plugin.getSelectedMedia().remove();
			// [IE] 删除图片后立即点击图片按钮出错
			self.addBookmark();
		}
	};
	self.clickToolbar(name, self.plugin.media.edit);
});
