<?php get_header(); ?>
    <main id="content">
        <div class="banner">
            <img class="main-logo" src="http://keketelbar.vertesipatrik.com/wp-content/uploads/2021/03/logo_blue_resize-1.png">
            <video width="100%" height="100%" autoplay muted loop poster="video.jpg" id="videobg">
                <source src="http://keketelbar.vertesipatrik.com/wp-content/uploads/2021/02/200506_Kitchen-Food_05_4k_048.mp4" type="video/mp4">
                <source src="video.webm" type="video/webm">
                <source src="video.ogg" type="video/ogg">
            </video>
        </div>
        <div class="ajanlatfeature">
            <div class="napitext wow bounceInUp">
                <h1>Mai menü ajánlatunk: </h1>
                <div class="napi-ajanlat-feature wow bounceInUp">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="header wow bounceInUp">
                            <h2 class="entry-title"><?php the_title(); ?></h2>
                        </header>
                        <div class="entry-content">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail();
                            } ?>
                            <?php the_content(); ?>
                            <div class="entry-links"><?php wp_link_pages(); ?></div>
                        </div>
                    </article>
                <?php endwhile; endif; ?>
                </div>
            </div>
            <div class="divider-wrapper">
                <img class="divider" src="http://keketelbar.vertesipatrik.com/wp-content/uploads/2021/03/pizzadivider.png">
            </div>
            <div class="featuretext" style="width: 100%; padding-bottom: 40px">
                <h1>Étlap</h1>
            </div>
            <?php  echo do_shortcode('[product_categories]'); ?>

        </div>
        <div class="divider-wrapper">
            <img class="divider" src="http://keketelbar.vertesipatrik.com/wp-content/uploads/2021/03/pizzadivider.png">
        </div>
        <div class="pizzafeature wow bounceInUp">
            <div class="featuretext wow bounceInUp">
                <h1 class=" wow bounceInUp">Üdvözöljük éttermünkben!</h1>
                <h2 class=" wow bounceInUp">Rendeljen kínálatunkból!</h2>
                <p class=" wow bounceInUp">Szívesen eltöltene egy kellemes és hangulatos estét magával ragadó éttermünkben, és megkóstolná magyaros vacsoráink különlegességeit?
				Kellemes környezetben, ízletes fogásokat kínál Önnek a Kék Söröző és Étterem. Örömmel várjuk Önt és családját a hét minden napján.</p>
				<h2 class=" wow bounceInUp">Kedvező fekvésű étterem sokoldalú étlappal</h2>
				<p class=" wow bounceInUp">Magyar konyhánk, ételeink széles választékával várja Önt. Finom gyorsételeink, friss és különleges ízviláguk miatt váltak ismertté.
				A kiváló borhoz, a hideg frissítő italokhoz, az alkoholos italokhoz, az aromás sörhöz és a friss kávéhoz rendkívül ízletes rántott szeletet vagy pizzákat tálalunk.
				Az édesszájúak is találnak kedvükre valót. Meleg palacsintáink vagy desszertjeink is rendkívül fenségesek. Élvezze a nálunk töltött ebédet vagy vacsorát!</p>
            </div>

        </div>
        <div class="divider-wrapper">
            <img class="divider" src="http://keketelbar.vertesipatrik.com/wp-content/uploads/2021/03/pizzadivider.png">
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2658.329188972271!2d20.286562015651857!3d48.219535479230046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x473f81b7db86ea3f%3A0x16c84ea5beff5669!2zS8OpayBTw7Zyw7Z6xZEgw6lzIMOJdHRlcmVt!5e0!3m2!1shu!2shu!4v1612985684641!5m2!1shu!2shu" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </main>

<?php get_footer(); ?>
