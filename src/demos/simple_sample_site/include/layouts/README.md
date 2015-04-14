This folder contains layouts. They are files with extension ".layout.php". They are
templates with custom sections inside. Custom content placeholders is expressed
with the notation ##path##, eg. ##/intestazione/sx## and set inside the page
with the directive "start_content($path)" and "end_content()".
For example, for setting the content with of placeholder ##/intestazione/sx## inside the
page file the function call is : start_content("/intestazione/sx");
When content of the section is finished user should call function "end_content();".
