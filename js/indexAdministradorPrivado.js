$(document).ready(function(){
    $("#cursos").popover({
        trigger: 'hover',        
        placement: 'top',
        title: 'Administrar Cursos',
        content: '-Crea nuevos cursos. <br>-Edita los ya existentes.<br>-Inscribe alumnos.<br>-Asigna grupos a los cursos.'        
    });
    $("#alumnos").popover({
        trigger: 'hover',        
        placement: 'top',
        title: 'Administrar Alumnos',
        content: '-Lista completa de los alumnos.<br>-Agrega más alumnos.<br>-Elimina alumnos.'        
    });
    $("#profesores").popover({
        trigger: 'hover',        
        placement: 'top',
        title: 'Administrar Profesores',
        content: '-Lista completa de los profesores.<br>-Agrega más profesores.<br>-Elimina profesores.'        
    });
    $("#grupos").popover({
        trigger: 'hover',        
        placement: 'top',
        title: 'Administrar Grupos',
        content: '-Lista completa de los grupos.<br>-Asigna alumnos a grupos.'        
    });
    $("#administradores").popover({
        trigger: 'hover',        
        placement: 'top',
        title: 'Otros Administradores',
        content: '-Lista completa de los administradores.<br>-Agrega más administradores.<br>-Elimina administradores.'        
    });
    $("#estadisticas").popover({
        trigger: 'hover',        
        placement: 'top',
        title: 'Estadísticas de uso',
        content: 'Estadísticas de uso de la plataforma:<br>-Uso de disco.<br>-Ancho de banda utilizado.<br>-Usuarios dados de alta.'        
    });
});