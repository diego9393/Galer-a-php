<center>
<div class="row">
    <?php 
    /*variables globales*/
    global $product;
    $posicionFotos = 1;

    /*se obtienen los enlaces*/
    $directorio = opendir("./img/slider");
        $ficheros = array();
        while ($archivo = readdir($directorio))
        {
            if (is_dir($archivo))
            {
                //echo "[".$archivo . "]<br />";
            }
            else
            {
                $ficheros[] = "/img/slider/" . $archivo;
            }
        }

        $longitudArray = count($ficheros);

        sort($ficheros,SORT_STRING);
    /*se pasa el valor de la foto actual del slider a una variable común*/
    $fotoSliderActual = $ficheros[$posicionFotos];

    /*se calcula la longitud del array de php*/
    $longitudArray = count($ficheros);
    ?>

    <!--se transfieren los valores del array de php al array de javascript-->
    <script>
    var fotosarrayJS = new Array();
    var posicionBucle = 0;

    var temporizadorInterval;

    </script>
    <?php
    for ($i = 0; $i < $longitudArray; $i++)
    {
        ?>

        <script>
        posicionBucle = <?php echo $i?>;
        fotosarrayJS[posicionBucle] = "<?php echo $ficheros[$i]; ?>";
        </script>

        <?php
    }
    ?>
    <div><span id="time" style="display:none;"></span></div>
    <script>
    //var sliderConfJS = <?php echo $sliderConf;?>;  
    //alert(sliderConfJS);		
    /*temporizador para cambiar automaticamente las fotos*/
    function startTimer(duration, display) 
    {
        var timer = duration, minutes, seconds;
        temporizadorInterval = setInterval(function () 
        {
            minutes = parseInt(timer / 60, 10)
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) 
            {
                timer = duration;
                cambiarImagenAdelante();
            }
        }, 1000);
    }

    window.onload = function () {
        var tiempo = 60 * 0.09;
        display = document.querySelector('#time');
        startTimer(tiempo, display);
    };

    /*reiniciar temporizador*/
    function reiniciarTemporizador(){		
        clearInterval(temporizadorInterval);
        var tiempo = 60 * 0.09;
        display = document.querySelector('#time');
        startTimer(tiempo, display);
    }

    /*variables slider*/
    var longitudArrayJS = fotosarrayJS.length;		
    var ultimaFotoSlider = longitudArrayJS -1;
    var posicionFotosJS = 0;
    var imagenSeleccionada;
    var cuentaArray = 0;

    var miniaturas;
    var posicionMiniaturas = new Array();

    /*ocultar slider si no hay imagenes*/
    if (longitudArrayJS == 0)
    {
        document.getElementById("sliderproductoAdelante").style.display = "none";
        document.getElementById("sliderproductoAtras").style.display = "none";
        document.getElementById("sliderproducto").style.display = "none";
        document.getElementById("miniaturas").style.display = "none";
    }
            
    /*generar miniaturas*/	
    for (var i = 0; i < longitudArrayJS; i++)
    {
        miniaturas = document.createElement("div");
        miniaturas.id = "miniatura" + i;
        miniaturas.className = "miniaturas";
        miniaturas.value = i;
        miniaturas.style.borderRadius = "50%";
        miniaturas.style.width = "10px";
        miniaturas.style.height = "10px";
        miniaturas.style.backgroundColor = "#00C1F4";
        miniaturas.style.marginRight = "2%";
        miniaturas.onclick = function () { 
            cambiarImagenMiniatura(this);
        };	
        document.getElementById("miniaturas").appendChild(miniaturas);
    }

    /*cambiar imagen desde las miniaturas*/
    function cambiarImagenMiniatura(pulsado)
    {
        reiniciarTemporizador();

        posicionFotosJS = pulsado.value;                
        imagenSeleccionada = fotosarrayJS[posicionFotosJS];    
        document.getElementById("sliderproducto").src = fotosarrayJS[posicionFotosJS];  
                                        
        dibujarResaltoImagen();                                            
    }

    /*se cambia de imagen según sea el botón pulsado*/	
    function cambiarImagenAtras()
    {
        reiniciarTemporizador();

        posicionFotosJS++;

        if (posicionFotosJS == longitudArrayJS)
        {
            posicionFotosJS = 1;
            document.getElementById("sliderproducto").src = fotosarrayJS[posicionFotosJS];
        }
        else
        {
            document.getElementById("sliderproducto").src = fotosarrayJS[posicionFotosJS];
        }

        dibujarResaltoImagen();
    }

    function cambiarImagenAdelante()
    {
        reiniciarTemporizador();
                    
        posicionFotosJS--;
        if (posicionFotosJS < 1)
        {
            posicionFotosJS = ultimaFotoSlider;
            document.getElementById("sliderproducto").src = fotosarrayJS[posicionFotosJS];
        }
        else
        {
            document.getElementById("sliderproducto").src = fotosarrayJS[posicionFotosJS];
        }

        dibujarResaltoImagen();
    }

    /*resaltar imagen mostrada*/
    function dibujarResaltoImagen()
    {
        var imagenActual = fotosarrayJS[posicionFotosJS];                   
        var posicionImagen = fotosarrayJS.indexOf(imagenActual);
        var imagenEstiloSeleccionada;
        var imagenEstiloNoSeleccionada;

        for (var i = 0; i < longitudArrayJS; i++)
        {
            imagenEstiloNoSeleccionada = document.getElementById("miniatura" + i).style;

            imagenEstiloNoSeleccionada.backgroundColor = "#00C1F4";

            if (posicionImagen == posicionFotosJS)
            {
                imagenEstiloSeleccionada = document.getElementById("miniatura" + posicionFotosJS).style;

                imagenEstiloSeleccionada.backgroundColor = "#000000";
            }
        }                 
    } 

    </script>
    <!--se muestra el slider en html-->
    <div id="slider">
        <div id="sliderproductoAtras" class="botonSlider" onclick="cambiarImagenAtras()"><img src="/img/iz.png" width="32px"></img></div>
        <div id="sliderproductoAdelante" class="botonSlider" onclick="cambiarImagenAdelante()"><img src="/img/der.png" width="32px"></img></div>
        <img id="sliderproducto" class="sliderproducto" src="<?php echo $fotoSliderActual;?>"></img>
        <a href="#slider"><div id="miniaturas"></div></a>
    </div>
</div>
</center>