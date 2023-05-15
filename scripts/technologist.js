function setEqualHeight(columns)
{
    var tallestcolumn = 0;
    columns.children().each(
        function()
        {
            currentHeight = $(this).height();
            if(currentHeight > tallestcolumn)
            {
                tallestcolumn = currentHeight+30;
            }
        }
    );
    columns.height(tallestcolumn);
}
$(document).ready(function() {
    setEqualHeight($(".column_content"));
});