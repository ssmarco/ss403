/* eslint-disable */
/**
 * The PayPal Accessibility Plugin adds accessibility improvements over the top of Bootstrap
 * components. It is designed to work in the background. If you experience any quirks, please
 * take a look at its source code.
 */
import bootstrap from 'bootstrap-accessibility-plugin/bs3.1.1/js/bootstrap';
import accessibility from 'bootstrap-accessibility-plugin/plugins/js/bootstrap-accessibility';
/* eslint-enable */


// Define local components
import carouselConfig from './components/carousel';
import navigation from './components/navigation';


carouselConfig();
navigation();
