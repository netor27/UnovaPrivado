$(document).ready(function(){
    if(layout == "desktop"){
        $("#cursos").popover({
            trigger: 'hover',        
            placement: 'right',
            title: 'Administrar Cursos',
            html: true,
            content: '-Crea nuevos cursos. <br>-Edita los ya existentes.<br>-Inscribe alumnos.<br>-Asigna grupos a los cursos.'        
        });
        $("#alumnos").popover({
            trigger: 'hover',        
            placement: 'right',
            title: 'Administrar Alumnos',
            html: true,
            content: '-Lista completa de los alumnos.<br>-Agrega más alumnos.<br>-Elimina alumnos.'        
        });
        $("#profesores").popover({
            trigger: 'hover',        
            placement: 'left',
            title: 'Administrar Profesores',
            html: true,
            content: '-Lista completa de los profesores.<br>-Agrega más profesores.<br>-Elimina profesores.'        
        });
        $("#grupos").popover({
            trigger: 'hover',        
            placement: 'right',
            title: 'Administrar Grupos',
            html: true,
            content: '-Lista completa de los grupos.<br>-Asigna alumnos a grupos.'        
        });
        $("#administradores").popover({
            trigger: 'hover',        
            placement: 'right',
            title: 'Otros Administradores',
            html: true,
            content: '-Lista completa de los administradores.<br>-Agrega más administradores.<br>-Elimina administradores.'        
        });
        $("#estadisticas").popover({
            trigger: 'hover',        
            placement: 'left',        
            title: 'Estadísticas de uso',
            html: true,
            content: 'Estadísticas de uso de la plataforma:<br>-Uso de disco.<br>-Ancho de banda utilizado.<br>-Usuarios dados de alta.'        
        });
    }
});