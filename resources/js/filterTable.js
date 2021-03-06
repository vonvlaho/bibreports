// insert searchbar
$('<input id="dataReducer" class="input mb-4" style="max-width:600px" type="text" placeholder="Suchbegriff">')
    .insertBefore('#dataTable table');

$('#dataReducer')
    .on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#dataTable tr')
            .filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
    });
