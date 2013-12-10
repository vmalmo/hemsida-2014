hemsida-2014
============

Plugins
--------------
Following plugins need to be activated and configured

### Wordpress Page Widgets
--------------
Below the default admin menu in wordpress there now "Page Widgets"

Select post types that should have individual widgets and which sidebar that the user can add widgets to

### VM14 - Post types
--------------
In the types folder in the plugin folder are the classes that define the post types. 
Each class has right now(2013-12-13) two methods, the constructor and register_acf. 

_The constructor_ extends the constructor of the base class. And uses the value to register a new post type. 

#### Custom fields
_register_acf_ adds custom fields that are needed to for the post type. The name pattern for the fields are {{post type}}_{{field}}.
So location on the calendar event got the name *calendar_event_location*. 

If you are looking for a specfic field and thinks Jon named it totally fucked up. Go to the file for that post type, look at the register_acf function, search for the field and look whats assigned to the name parameter. And change it to something better. 

#### get values from fields

To get the raw value that wordpress saved for a specific field use ```get_post_meta($post_id, '{{post type}}_{{field}}'));```

in the case above with calendar event location it would be
```get_post_meta($post_id, 'calendar_event_location'));```


If you want a pre formatted value by the advance custom fields library, go
```get_field('{{post type}}_{{field}}')```

or if you want it echoed out right a way:
```the_field('{{post type}}_{{field}}')```
	




