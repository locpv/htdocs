<script language="JavaScript" type="text/javascript" src="<?php echo plugins_url('download-manager/js/jquery.dataTables.js'); ?>"></script> 
<link rel="stylesheet" href="<?php echo plugins_url('download-manager/css/jquery.dataTables.css'); ?>" type="text/css" media="all" />
<div class="wpdmpro">
<div class="container-fluid">
<table id="wpdmmydls" style="width: 100%;" class="dtable table-bordered zebra-striped">
<thead><tr>
<th class="">Title</th>
<th>Create Date</th>
<th style="width: 100px;">Download</th></tr></thead>
<tbody>
<?php 
global $wpdm_download_button_class, $wpdm_login_icon, $wpdm_download_icon, $wpdm_lock_icon;
$wpdm_download_button_class = ''; 
$wpdm_login_icon = $wpdm_download_icon = $wpdm_lock_icon = '';
if(!is_array($myfiles)) $myfiles = array();
foreach($myfiles as $mfile):  $mfile = wpdm_flat_url($mfile); ?>
<tr><td><a href='<?php echo $mfile['page_url']; ?>'><?php echo htmlspecialchars(stripcslashes($mfile['title'])); ?></a></td>
<td><?php echo date("Y-m-d",$mfile['create_date']); ?></td>
<td><?php echo DownloadLink($mfile, $style='simple-dl-link'); ?></td></tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
<script type="text/javascript" charset="utf-8">
            /* Default class modification */
            jQuery.extend( jQuery.fn.dataTableExt.oStdClasses, {
                "sSortAsc": "header headerSortDown",
                "sSortDesc": "header headerSortUp",
                "sSortable": "header"
            } );

            /* API method to get paging information */
            jQuery.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
            {
                return {
                    "iStart":         oSettings._iDisplayStart,
                    "iEnd":           oSettings.fnDisplayEnd(),
                    "iLength":        oSettings._iDisplayLength,
                    "iTotal":         oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
                    "iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
                };
            }

            /* Bootstrap style pagination control */
            jQuery.extend( jQuery.fn.dataTableExt.oPagination, {
                "bootstrap": {
                    "fnInit": function( oSettings, nPaging, fnDraw ) {
                        var oLang = oSettings.oLanguage.oPaginate;
                        var fnClickHandler = function ( e ) {
                            if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
                                fnDraw( oSettings );
                            }
                        };

                       jQuery(nPaging).addClass('pagination').append(
                            '<ul>'+
                                '<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
                                '<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
                            '</ul>'
                        );
                        var els =jQuery('a', nPaging);
                       jQuery(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
                       jQuery(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
                    },

                    "fnUpdate": function ( oSettings, fnDraw ) {
                        var oPaging = oSettings.oInstance.fnPagingInfo();
                        var an = oSettings.aanFeatures.p;
                        var i, sClass, iStart, iEnd, iHalf=Math.floor(oPaging.iTotalPages/2);

                        if ( oPaging.iTotalPages < 5) {
                            iStart = 1;
                            iEnd = oPaging.iTotalPages;
                        }
                        else if ( oPaging.iPage <= iHalf ) {
                            iStart = 1;
                            iEnd = 5;
                        } else if ( oPaging.iPage >= (5-iHalf) ) {
                            iStart = oPaging.iTotalPages - 5 + 1;
                            iEnd = oPaging.iTotalPages;
                        } else {
                            iStart = oPaging.iPage - Math.ceil(5/2) + 1;
                            iEnd = iStart + 5 - 1;
                        }

                        for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
                            // Remove the middle elements
                           jQuery('li:gt(0)', an[i]).filter(':not(:last)').remove();

                            // Add the new list items and their event handlers
                            for ( i=iStart ; i<=iEnd ; i++ ) {
                                sClass = (i==oPaging.iPage+1) ? 'class="active"' : '';
                               jQuery('<li '+sClass+'><a href="#">'+i+'</a></li>')
                                    .insertBefore('li:last', an[i])
                                    .bind('click', function () {
                                        oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                                        fnDraw( oSettings );
                                    } );
                            }

                            // Add / remove disabled classes from the static elements
                            if ( oPaging.iPage === 0 ) {
                               jQuery('li:first', an[i]).addClass('disabled');
                            } else {
                               jQuery('li:first', an[i]).removeClass('disabled');
                            }
                             
                            if ( oPaging.iPage === oPaging.iTotalPages-1 ) {
                               jQuery('li:last', an[i]).addClass('disabled');
                            } else {
                               jQuery('li:last', an[i]).removeClass('disabled');
                            }
                        }

                    }
                }
            } );

            /* Table initialisation */
           jQuery(document).ready(function() {
               jQuery('#wpdmmydls').dataTable( {
                    "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
                    "sPaginationType": "bootstrap"
                } );
            } );
        </script>