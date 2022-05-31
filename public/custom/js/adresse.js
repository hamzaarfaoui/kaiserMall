$('#submit-adresse-form').submit(function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function(data)
        {
            if(data['id']) {
                $('.edit-adress-modal').modal('hide');
                $('body').find('div#adresse'+data['id']).replaceWith($(data.html));
            }else{
                $('#addAdresseModal').modal('hide');
                $('.block-list-adresse').append($(data.html)); // show response from the php script.
            }
            
            
        }
    });


});
$(".delete-adress").click(function(e){  
    e.preventDefault();
    var href = $(this).attr('href');

    $.ajax({
        url: href
    }).done(function (data) {
        $("#adresse"+data['id']).hide();
    });


});

