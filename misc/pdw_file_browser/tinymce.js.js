function filebrowser(field_name, url, type, win) {
	    
    fileBrowserURL = "http://sgc.leiaja.com/misc/pdw_file_browser/index.php?editor=tinymce&filter="+type+";
	      
    tinyMCE.activeEditor.windowManager.open({
	        title: "Visualizador de Imagens",
	        url: fileBrowserURL,
	        width: 950,
	        height: 650,
	        inline: 0,
	        maximizable: 1,
	        close_previous: 0
	      },{window : win, input : field_name}
	    );
}