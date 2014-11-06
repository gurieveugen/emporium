<?php

/*

Template Name: Sorting blog page

*/

?>



<?php get_header(); 



?>





<div id="mainwrap">



	<div id="main" class="clearfix">



	<div class="infotextwrap">

		<div class="infotext">

			<div class="infotextBorder"></div>

				<h1><?php the_title();?></h1>

				<div class="homeIcon"><a href="<?php echo home_url(); ?>"></a></div>

			<div class="infotextBorder"></div>

		</div>

	</div>		

	

	<div id="remove" class="portfolioremove">

	    <h2><a class="catlink" href="#filter=*" >Show All <span> </span></a>

		<?php $categories = get_terms("category");

		foreach ($categories as $category) {

			$entrycategory = str_replace(' ', '-', $category->name);

			echo '<a class="catlink" href="#filter=.'.$entrycategory .'" >'.$category->name.'<span class="aftersortingword"> </span></a>';

		}

		?>

		</h2>

	</div>

	

	<div class="portfolioline"></div>





	<div class="portfolio">		

	

		<div id="portitems4">

					

			<?php portfolio(135,233,4,'post'); ?>

					

		</div>

					

		<?php

		include('includes/wp-pagenavi.php');

		if(function_exists('wp_pagenavi')) { wp_pagenavi(); }

		?>

				

	</div>

	

</div>	

</div>

<script>

	   jQuery(function(){

  

      var $container = jQuery('#portitems4'),

          // object that will keep track of options

          isotopeOptions = {},

          // defaults, used if not explicitly set in hash

          defaultOptions = {

            filter: '*',

            sortBy: 'original-order',

            sortAscending: true,

            layoutMode: 'masonry'

          };



      // ensure no transforms used in Opera

      if ( jQuery.browser.opera ) {

        defaultOptions.transformsEnabled = false;

      }

      

     

  

      var setupOptions = jQuery.extend( {}, defaultOptions, {

        itemSelector : '.item4',

      });

  

      // set up Isotope

      $container.isotope( setupOptions );

  

      var $optionSets = jQuery('#options').find('.option-set'),

          isOptionLinkClicked = false;

  

      // switches selected class on buttons

      function changeSelectedLink( $elem ) {

        // remove selected class on previous item

        $elem.parents('.option-set').find('.selected').removeClass('selected');

        // set selected class on new item

        $elem.addClass('selected');

      }

  

  

      $optionSets.find('a').click(function(){

        var $this = $(this);

        // don't proceed if already selected

        if ( $this.hasClass('selected') ) {

          return;

        }

        changeSelectedLink( $this );

            // get href attr, remove leading #

        var href = $this.attr('href').replace( /^#/, '' ),

            // convert href into object

            // i.e. 'filter=.inner-transition' -> { filter: '.inner-transition' }

            option = $.deparam( href, true );

        // apply new option to previous

        jQuery.extend( isotopeOptions, option );

        // set hash, triggers hashchange on window

        jQuery.bbq.pushState( isotopeOptions );

        isOptionLinkClicked = true;

        return false;

      });



      var hashChanged = false;



      jQuery(window).bind( 'hashchange', function( event ){

        // get options object from hash

        var hashOptions = window.location.hash ? jQuery.deparam.fragment( window.location.hash, true ) : {},

            // do not animate first call

            aniEngine = hashChanged ? 'best-available' : 'none',

            // apply defaults where no option was specified

            options = jQuery.extend( {}, defaultOptions, hashOptions, { animationEngine: aniEngine } );

        // apply options from hash

        $container.isotope( options );

        // save options

        isotopeOptions = hashOptions;

    

        // if option link was not clicked

        // then we'll need to update selected links

        if ( !isOptionLinkClicked ) {

          // iterate over options

          var hrefObj, hrefValue, $selectedLink;

          for ( var key in options ) {

            hrefObj = {};

            hrefObj[ key ] = options[ key ];

            // convert object into parameter string

            // i.e. { filter: '.inner-transition' } -> 'filter=.inner-transition'

            hrefValue = jQuery.param( hrefObj );

            // get matching link

            $selectedLink = $optionSets.find('a[href="#' + hrefValue + '"]');

            changeSelectedLink( $selectedLink );

          }

        }

    

        isOptionLinkClicked = false;

        hashChanged = true;

      })

        // trigger hashchange to capture any hash data on init

        .trigger('hashchange');



    });



</script>



	

<?php get_footer(); ?>