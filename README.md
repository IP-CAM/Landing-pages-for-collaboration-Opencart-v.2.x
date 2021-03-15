# Opencart-2.x-Landing-pages-for-collaboration
We create landing pages for wholesale

The module was made to create landing pages for wholesale / dropshipping, allows you to specify your own tags for the page, add a description.
Depending on the selected page type, it displays products on the landing page from: category X, manufacturer Y, category X from manufacturer Y.

Installation:
1. Upload the admin and catalog folders to the root
2. Create a table in the oc_opt database
3. Upload the ocmod file through the admin panel: add-ons> install add-ons.
4. Refresh the cache.

Crutch for SEOPRO
Links to the page look like site.loc / opt / seoname
For seo_pro to work, you need to add a correspondence to the alias table:
module / optpage => opt

Applications are sent to the mail from the settings.
If description / meta-tags are not specified, they are specified according to the template (look in the front controller)

The module was made for version 2.1.0.1.1 - but it should work for others as well.
