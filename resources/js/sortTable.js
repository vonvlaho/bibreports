var table = $('#dataTable table');

$('#dataTable table th')
    .append('<i class="fas fa-sort" style="display:inline;margin-left:5px"></i>')
    .css('cursor', 'pointer')
    .each(function(){

        var th = $(this),
            thIndex = th.index(),
            inverse = false;

        th.click(function(){

            table.find('td').filter(function(){

                return $(this).index() === thIndex;

            }).sortElements(function(a, b){

                a = $(a).text();
                b = $(b).text();

                return (
                    isNaN(a) || isNaN(b) ?
                        a > b : +a > +b
                ) ?
                    inverse ? -1 : 1 :
                    inverse ? 1 : -1;

            }, function(){

                // parentNode is the element we want to move
                return this.parentNode;

            });

            inverse = !inverse;

        });

    });
