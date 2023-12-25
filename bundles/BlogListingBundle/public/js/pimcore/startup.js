pimcore.registerNS("pimcore.plugin.BlogListingBundle");

pimcore.plugin.BlogListingBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // alert("BlogListingBundle ready!");
    }
});

var BlogListingBundlePlugin = new pimcore.plugin.BlogListingBundle();
