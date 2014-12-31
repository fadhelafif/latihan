<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Heading Form</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
        <script language="javascript" type="text/javascript" src="../../../../../wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
        <script language="javascript" type="text/javascript">
            function calibrefx_zobrazForm() {
		
                tinyMCEPopup.resizeToInnerSize();
                var medziShortcodom = tinyMCE.activeEditor.selection.getContent();		
                if(medziShortcodom != '') {			
                    document.getElementById('text_text').value = medziShortcodom;
                }		
            }
	
            function calibrefx_vlozSC() {
                // shortcode sam
                var shortcodeRetazec;
		
                // ziskaj text medzi shortcode tagmi
                var medziShortcodom = tinyMCE.activeEditor.selection.getContent();
                // ziskaj hodnoty z formu			
                var text_color = document.getElementById('text_color').value;
                var text_font = document.getElementById('text_font').value;
                var text_style = document.getElementById('text_style').value;
                var text_type = document.getElementById('text_type').value;


                shortcodeRetazec = '[' + text_type + ' color="' + text_color + '" font="' + text_font + '" font_style="' + text_style + '"]YOUR HEADING TEXT HERE[/' + text_type + ']';
    
                //vloz shortcode a repaint editor
                if(window.tinyMCE) {
                    //window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodeRetazec);
                    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcodeRetazec);
                    tinyMCEPopup.editor.execCommand('mceRepaint');
                    tinyMCEPopup.close();
                }
	
                return;
            }
        </script>
        <base target="_self" />

        <style type="text/css">

            label span { color: #f00; }

        </style>

    </head>
    <body onload="calibrefx_zobrazForm();">
        <form name="calibrefx_sc_form" action="#">
            <div class="tabs">
                <ul>
                    <li id="textTabID" class="current"><span><a href="javascript:mcTabs.displayTab('textTabID','textTab');" onmousedown="return false;">Headings</a></span></li>            
                </ul>
            </div>

            <div class="panel_wrapper" style="height: 200px;">

                <div id="textTab" class="panel current" style="height: 200px">

                    <fieldset>        
                        <legend>Heading Style</legend><br />  

                        <table border="0" cellpadding="4" cellspacing="0">     
                            <!-- Heading Type -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="text_type">Heading Type:</label>
                                </td>                          
                                <td>                    
                                    <select name="text_type" id="text_type" style="width: 210px"> 
                                        <option value="h1">Heading 1</option>                        
                                        <option value="h2">Heading 2</option>                  
                                        <option value="h3">Heading 3</option>
                                        <option value="h4">Heading 4</option>  
                                        <option value="h5">Heading 5</option>  
                                        <option value="h6">Heading 6</option>                
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select heading type</em>
                                </td>                    
                            </tr>           
                            <!-- Color -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="text_color">Color:</label></td>                          <td>                    
                                    <select name="text_color" id="text_color" style="width: 210px">     
                                        <option value="color-default">Default</option>                  
                                        <option value="black">Black</option>
                                        <option value="white">White</option>  
                                        <option value="red">Red</option>  
                                        <option value="light-blue">Light Blue</option>  
                                        <option value="dark-blue">Dark Blue</option>
                                        <option value="light-green">Light Green</option>
                                        <option value="dark-green">Dark Green</option>                            
                                        <option value="violet">Violet</option>  
                                        <option value="brown">Brown</option> 
                                        <option value="yellow">Yellow</option>
                                        <option value="orange">Orange</option>
                                        <option value="pink">Pink</option>  
										<option value="gold">Gold</option> 
                                        <option value="green">Green</option>
                                        <option value="grey">Grey</option>
                                        <option value="purple">Purple</option>  										
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select color.</em>                
                                </td>                    
                            </tr>  
                            <!-- Font family -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="text_font">Font family:</label></td>                          <td>                    
                                    <select name="text_font" id="text_font" style="width: 210px"> 
										<option value="default">Default</option>  									
                                        <option value="arial">Arial</option>                  
                                        <option value="verdana">Verdana</option>
                                        <option value="times">Times New Roman</option>  
                                        <option value="geneva">Geneva</option>  
                                        <option value="courier">Courier New</option>  
                                        <option value="sans">MS Sans Serif</option>
                                        <option value="system">System</option>
                                        <option value="georgia">Georgia</option>                                   
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select font family.</em>                
                                </td>                    
                            </tr>
                            <!-- Font style -->       
                            <tr>                 
                                <td nowrap="nowrap" style="vertical-align: text-top;"><label for="text_style">Font style:</label></td>                          <td>                    
                                    <select name="text_style" id="text_style" style="width: 210px">     
                                        <option value="normal">Normal</option>                  
                                        <option value="italic">Italic</option>
                                        <option value="oblique">Oblique</option>                                                        
                                    </select><br />      
                                    <em style="font-size: 9px; color: #999;">Select style.</em>                
                                </td>                    
                            </tr>                              
                        </table>     
                    </fieldset>
                </div><!-- /#textTab -->

            </div><!-- /.panel_wrapper -->

            <div class="mceActionPanel">
                <div style="float: left;">
                    <input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
                </div>
                <div style="float: right">
                    <input type="submit" id="insert" name="insert" value="Insert" onclick="calibrefx_vlozSC();" />
                </div>
            </div>
        </form>
    </body>
</html>