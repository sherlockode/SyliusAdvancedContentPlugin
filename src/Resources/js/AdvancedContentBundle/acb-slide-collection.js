import slide from './acb-slide.js';
import 'sylius/bundle/UiBundle/Resources/private/js/sylius-form-collection';

slide.element.on('slideContentUpdated', function() {
  slide.content.find('[data-form-type="collection"]').CollectionForm();
});
