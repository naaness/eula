 $(document).ready(function() {
    var server = "http://"+window.location.hostname;
    $.post(server+'/cursos/get_audios/'+purldf, function(data){
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', data);
        audioElement.setAttribute('autoplay', 'autoplay');
        //audioElement.load()

        $.get();

        audioElement.addEventListener("load", function() {
            audioElement.play();
        }, true);

        $('.play').click(function() {
            audioElement.play();
        });

        $('.pause').click(function() {
            audioElement.pause();
        });
    });
});