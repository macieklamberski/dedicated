/*
 *  Kohana CMF (September 2011)
 *  Crafted with passion by http://lamberski.com
 */
Padamini.enableLangTabs = function() {

  $("div.wysiwyg").each(function() {
    $(this).attr("rel", $(this).next().attr("name"));
  });

  $(".field-tabs input").bind("change", function() {
    if ($(this).attr("checked")) {

      var lang = $(this).attr("value");
      var i18n_fieldset = $(this).closest("fieldset");

      // Hiding inputs for each language
      i18n_fieldset.find(".field [id^=form], .field [rel]").each(function() {

        // Ignoring .jwysiwyg textarea
        if (!($(this).is("textarea") && $(this).hasClass("jwysiwyg"))) {
          if ($(this).attr("name")) {
            $(this).data("id", $(this).attr("id"));
            $(this).removeAttr("id");
          }
          $(this).hide();
        }
      });

      // Showing inputs for only currently selected language
      i18n_fieldset.find("[rel$=" + lang + "], .field [name$=" + lang + "], .field [name$='" + lang + "]']").each(function() {

        // Ignoring .wysiwyg textarea
        if (!($(this).is("textarea") && $(this).hasClass("jwysiwyg"))) {
          $(this).attr("id", $(this).data("id"));
          $(this).show();
        }
      });

      Padamini.enableInputAutofocus(i18n_fieldset.find(".field:nth-child(2)"));
    }

    return false;
  });

  // Checking first language
  $(".field-tabs input").first().attr("checked", "checked").change();
};