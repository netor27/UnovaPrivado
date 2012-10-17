<script src="/lib/js/jqueryGridster/jquery.gridster.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var gridster;
    $(function(){
        gridster = $(".gridster ul").gridster({
            widget_margins: [5, 5],
            widget_base_dimensions: [140, 140],
            min_cols: 6,
            min_rows: 20,
            serialize_params: function($w, wgd) { 
                return { 
                    col: wgd.col, 
                    row: wgd.row,
                    size_x: wgd.size_x,
                    size_y: wgd.size_y,
                    id: $w.attr("id")
                } 
            }
        }).data('gridster');
        //gridster.disable();
    });
</script>