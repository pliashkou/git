$(document).ready(function () {
    var app = new Corbis(new CorbisView());
    app.init();
});

function Corbis(view) {
    this.view = view;
    var self = this;

    this.init = function () {

        $('.grid-view').click(function () {
            self.onGridViewSelect();
            return false;
        });

        $('.simple-view').click(function () {
            self.onSimpleViewSelect();
            return false;
        });

        $('.image-details').click(function () {
            self.showDetails(this.data);
            return false;
        })
    };

    this.onGridViewSelect = function () {
        console.log('Grid view selected');
    };

    this.onSimpleViewSelect = function () {
        console.log('Simple view selected');
    };

    this.showDetails = function (data) {
        console.log('Show details: ' + data);
    }
}

