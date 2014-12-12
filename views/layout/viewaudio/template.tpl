<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>{$titulo|default:"Sin título"}</title>
    <link rel="stylesheet" type="text/css" href="{$template_dir}plugin/css/style.css">
    <link rel="stylesheet" type="text/css" href="{$template_dir}css/demo.css">
    <script type="text/javascript" src="{$template_dir}js/jquery.min.js"></script>
    <script type="text/javascript" src="{$template_dir}plugin/jquery-jplayer/jquery.jplayer.js"></script>
    <script type="text/javascript" src="{$template_dir}plugin/ttw-music-player.js"></script>
    <script type="text/javascript" src="{$template_dir}js/myplaylist.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var description = '{$datos.description}';
            var server = "http://"+window.location.hostname;
            $.post(server+'/cursos/get_audios/{$purldf}', function(data){
                $('body').ttwMusicPlayer(data, {
                    autoPlay:false, 
                    description:description,
                    jPlayer:{
                        swfPath:'{$template_dir}plugin/jquery-jplayer' //You need to override the default swf path any time the directory structure changes
                    }
                });
            }, 'json');

            
        });
        var endTrackCallback = function(index, playlistItem){
            
        }
    </script>
</head>
<body>
<a href="http://eula.com/cursos/editar_audio/{$purldf}" id="download">Regresar</a>
</body>
</html>