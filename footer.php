<?php wp_footer(); ?>

    <canvas class='particle-js'></canvas>
    <script type="text/javascript">
        window.onload = () => {

            let pageLoader = document.getElementById('rks-page-loader')
            pageLoader.style.opacity = 0;
            setTimeout(function(){  
                pageLoader.remove();
            }, 1500);

            Particles.init({
                selector: '.particle-js',
                color: '#ffffff40',
                maxParticles: 50,
                speed: .9
            });

        };
    </script>
</body>
</html>