# Customer Feedback

This WordPress plugin adds a feedback form to the end of every page (or any other activated post type). The visitor can then answer a question like "did the information on the current page help you?", yes or no. The results will be stored and presented in the admin area.

Filter reference
----------------

#### CustomerFeedback/post_types

> Array with post type slugs where the customer feedback form should be shown

*Example:*

```php
add_filter('CustomerFeedback/post_types', function ($postTypes) {
    $postTypes[] = 'post';
    return $postTypes;
});
```

---
