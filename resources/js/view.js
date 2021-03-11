// insert view switch buttons
$('<div class="buttons has-addons is-centered mt-6">\n' +
    '  <button id="tableButton" class="button is-info is-selected">Tabelle</button>\n' +
    '  <button id="diagramButton" class="button">Diagramm</button>\n' +
    '</div>')
    .insertBefore('#dataTable');

$('#dataChart').hide();

$('#tableButton').click(function() {
    $('#dataChart').hide();
    $('#diagramButton').removeClass("is-info is-selected");
    $('#tableButton').addClass("is-info is-selected");
    $('#dataTable').show();
});

$('#diagramButton').click(function() {
    $('#dataTable').hide();
    $('#tableButton').removeClass("is-info is-selected");
    $('#diagramButton').addClass("is-info is-selected");
    $('#dataChart').show();
});
