(function($) {
    // Kada klikneš na red u tabeli
    $('table#grades-table tbody tr').click(function() {
      var subjectId = $(this).data('subject-id');
      var row = $(this);
  
      // Ako je već otvoren, zatvori ga
      if (row.next('.grades-details').length > 0) {
        row.next('.grades-details').slideUp();
      } else {
        // Ako nije otvoren, zatvori sve otvorene i otvori ovaj
        $('tr.grades-details').slideUp();
        
        var gradesData = row.data('grades');
        var gradesDetails = JSON.parse(gradesData);
  
        var details = $('<tr class="grades-details"><td colspan="2"></td></tr>');
        var gradesDetailsHtml = '<ul>';
        
        gradesDetails.forEach(function(grade) {
          gradesDetailsHtml += '<li>' + grade.ocena + ' (' + grade.tip + ', ' + grade.datum + ')</li>';
        });
        
        gradesDetailsHtml += '</ul>';
  
        details.find('td').html(gradesDetailsHtml);
        row.after(details);
        details.slideDown();
      }
    });
  })(jQuery);
  