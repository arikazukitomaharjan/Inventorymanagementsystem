
			</div>
			<!--  end content-table  -->
        <div class="clear"></div>
      </div>
      <!--  end content-table-inner  -->
    </td>
    <td id="tbl-border-right"></td>
  </tr>
  <tr>
    <th class="sized bottomleft"></th>
    <td id="tbl-border-bottom">&nbsp;</td>
    <th class="sized bottomright"></th>
  </tr>
</table>

	<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
    
<!-- start footer -->         
<div id="footer">
<!-- <div id="footer-pad">&nbsp;</div> -->
	<!--  start footer-left -->
	<div id="footer-left">
	 &copy; Copyright Digital Agency Catmandu. <a href="http://www.digitalagencycatmandu.com" target="_blank">www.digitalagencycatmandu.com</a>. All rights reserved.</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
<!-- end footer -->


            <!--  jquery core -->
<!--            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
                <script src="js/jquery/jquery-2.1.4.min.js" type="text/javascript"></script>

            <Script src="js/bootstrap.min.js" type="text/javascript"/>

            <script src="https://use.fontawesome.com/a1419c4bc3.js"></script>
            <!--    <script src="js/jquery/date.js" type="text/javascript"></script>-->
            <!--    <script src="js/jquery/jquery.datePicker.js" type="text/javascript"></script>-->
            <!--    <script type="text/javascript" src="js/tcal.js"></script>-->

            <!--  checkbox styling script -->
            <script src="js/jquery/ui.core.js" type="text/javascript"></script>
            <!--    <script src="js/jquery/ui.checkbox.js" type="text/javascript"></script>-->
            <!--    <script src="js/jquery/jquery.bind.js" type="text/javascript"></script>-->
            <!--    <script src="js/jquery/jquery.modal.min.js" type="text/javascript"></script>-->
            <!--<script type="text/javascript">
                $(function () {
                    $('input').checkBox();
                    $('#toggle-all').click(function () {
                        $('#toggle-all').toggleClass('toggle-checked');
                        $('#mainform input[type=checkbox]').checkBox('toggle');
                        return false;
                    });
                });
            </script>-->

            <![if !IE 7]>

            <!--  styled select box script version 1 -->
            <!--    <script src="js/jquery/jquery.selectbox-0.5.js" type="text/javascript"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('.styledselect').selectbox({inputClass: "selectbox_styled"});
                    });
                </script>-->

            <![endif]>

            <!--  styled select box script version 2 -->
            <!--    <script src="js/jquery/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>-->
            <!-- <script type="text/javascript">
                 $(document).ready(function () {
                     $('.styledselect_form_1').selectbox({inputClass: "styledselect_form_1"});
                     $('.styledselect_form_2').selectbox({inputClass: "styledselect_form_2"});
                 });
             </script>-->

            <!--  styled select box script version 3 -->
            <!--    <script src="js/jquery/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>-->
            <!-- <script type="text/javascript">
                 $(document).ready(function () {
                     $('.styledselect_pages').selectbox({inputClass: "styledselect_pages"});
                 });
             </script>

             <!--  styled file upload script
             <script src="js/jquery/jquery.filestyle.js" type="text/javascript"></script>
             <script type="text/javascript" charset="utf-8">
                 $(function () {
                     $("input.file_1").filestyle({
                         image: "images/forms/choose-file.gif",
                         imageheight: 21,
                         imagewidth: 78,
                         width: 310
                     });
                 });
             </script>-->

            <!-- Custom jquery scripts -->
            <!--    <script src="js/jquery/custom_jquery.js" type="text/javascript"></script>-->

            <!-- Tooltips -->
            <script src="js/jquery/jquery.tooltip.js" type="text/javascript"></script>
            <!--    <script src="js/jquery/jquery.dimensions.js" type="text/javascript"></script>-->
            <script src="js/bootstrap-datepicker.js" type="text/javascript"></script>
            <script type="text/javascript">
//                $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
                $('.datepicker').datepicker({ format: 'yyyy-mm-dd' });
                $(function () {
                    $('a.info-tooltip ').tooltip({
                        track: true,
                        delay: 0,
                        fixPNG: true,
                        showURL: false,
                        showBody: " - ",
                        top: -35,
                        left: 5
                    });
                });
            </script>

            <!--  date picker script -->




            <!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
            <!--<script src="js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                    $(document).pngFix();
                });



            </script>
        -->


</body>
</html>