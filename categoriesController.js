angular
.module('unidbApp')
.controller('categoriesCtrl',
    ['$state',
    '$rootScope',
    '$scope',
    'tmhDynamicLocale',
    '$translate',
    '$timeout',
    '$filter',
    '$window',
    'variables',
    'categoriesService',
    function ($state, $rootScope, $scope, tmhDynamicLocale, $translate, $timeout, $filter, $window, variables, categoriesService) {

	    tmhDynamicLocale.set("en");

        $scope.notificationWidget = $("#notification").kendoNotification({
            autoHideAfter: variables.notification_timeout,
            position: {
                pinned: false,
                top: 30,
                right: 30
            }
        }).data("kendoNotification");
       
        $scope.windowTemplate = kendo.template($("#windowTemplate").html());	
    
        manageCategories();

        var _window = $("#window").kendoWindow({
                    title: "Are you sure you want to delete this record?",
                    actions: ["Close"],
                    draggable: true,
                    modal: true,
                    resizable: false,
                    visible: false,
                    width:400,
                    height:100,
                    content: "",
                    open: function() {      
                    }
                }).data("kendoWindow");

            function manageCategories(){
            angular.element(document).find("#page_preloader").show();
            angular.element(document).find("#page_preloader").css('opacity', '1');

            categoriesService.getCategories().then (function (categoriesServiceData) {
                angular.element(document).find("#page_preloader").hide();
                var categoriesData = [];
                if(categoriesServiceData.data.data != null) {
                    categoriesData = categoriesServiceData.data.data;
                }

                function getIndexById(id) {    
                    var filteredResult = new jinqJs()
                        .from(categoriesData)
                        .where( function(row) { return (row.id == id); } )
                        .select();
                        if(filteredResult.length > 0){
                            return filteredResult[0];
                        }    
                        return null;
                }

                function read(e){
                    e.success(categoriesData);
                }
                

                function create(e){
                    if(e.data.label != ""){
                    angular.element(document).find("#page_preloader").show();
                    angular.element(document).find("#page_preloader").css('opacity', '0.6');
                    categoriesService.createCategories(e.data).then (function (response){
                    angular.element(document).find("#page_preloader").hide();

                        if(response.message == "success" || response.message == "Success") {
                            categoriesService.getCategories().then (function (categoriesResponse) {
                                if(categoriesResponse.data.data != null){
                                categoriesData = categoriesResponse.data.data;
                                e.success(categoriesData);
                                $('#Grid').data('kendoGrid').dataSource.read();
                                $('#Grid').data('kendoGrid').refresh();
                                $scope.notificationWidget.show("Created successfully","success");
                                }
                            });     
                        }else{
                        if(e.data.label != ""){
                                $scope.notificationWidget.show(response.message,"error");
                                $('#Grid').data('kendoGrid').dataSource.read();
                            }
                        }
                    });
                  }
                }


                function update(e){
                angular.element(document).find("#page_preloader").show();
                angular.element(document).find("#page_preloader").css('opacity', '0.6');
                    if(e.data.label==""){
                        destroy(e);
                    }
                    else{
                        categoriesService.updateCategories(e.data).then(function(response){
                            angular.element(document).find("#page_preloader").hide();
                            categoriesService.getCategories().then (function (categoriesResponse) {
                                if(categoriesResponse.data.data != null){
                                categoriesData = categoriesResponse.data.data;
                                e.success(categoriesData);
                                $('#Grid').data('kendoGrid').dataSource.read();
                                $('#Grid').data('kendoGrid').refresh();
                                $scope.notificationWidget.show("Updated successfully","success");
                                }
                            });
                        })
                    }
                }

               
                function edit(e) {
                    $('.k-input').on('keypress', function (e) { 
                        var code = e.keyCode || e.which;
                         if(code == 13) { //Enter keycode
                            $('.k-grid-save-changes').focus().trigger('click'); 
                         }
                    });
                }

                function destroy(e){
                   categoriesService.deleteCategoriesById(e.data).then (function (response) {
                    angular.element(document).find("#page_preloader").hide();
                    if(response.message == "success" || response.message == "Success") {
                        categoriesService.getCategories().then (function (categoriesResponse) {
                            if(categoriesResponse.data.data != null){
                                categoriesData = categoriesResponse.data.data;
                                e.success(categoriesData);
                                $('#Grid').data('kendoGrid').dataSource.read();
                                $('#Grid').data('kendoGrid').refresh();
                                $scope.notificationWidget.show("Deleted successfully","success");
                               }
                             });
                    } else{
                        $('#Grid').data('kendoGrid').dataSource.read();
                        $('#Grid').data('kendoGrid').refresh();
                        e.success();
                        $scope.notificationWidget.show(response.message,"error");
                    }
                   });    
                }

                $scope.mainGridOptions = {
                    dataSource: {
                        transport: {
                            read: read,
                            create: create,
                            update: update,
                            //destroy: destroy,
                        },
                        schema: {
                            model: {
                                id: "id",
                                fields: {
                                    id: { editable: false, nullable: true},
                                    catlabel:{ editable: false, nullable: true},
                                    langlabel:{ editable: false, nullable: true},
                                    label:{editable: true}
                                }
                            }
                        }
                    },
                    edit: edit,
                    batch: false,
                    pageable: false,
                    sortable: true,
                    selectable: 'row',
                    resizable: true,
                    height: 500,
                    editable: true,
                    //deletable: "batch",
                    scrollable: {
                    virtual: false
                },

                toolbar: ["save","cancel"],

                columns: [{
                    field: "id",
                    title: $translate.instant('restricted.categories.id'),
                    width: 50
                },{
                    field: "catlabel",
                    title: $translate.instant('restricted.categories.categories'),
                    width: 100
                },{
                    field: "langlabel",
                    title: $translate.instant('restricted.categories.languages'),
                    width: 100
                },{
                    field: "label",
                    title: $translate.instant('restricted.categories.translation'),
                    width: 120
                }
                ]
            };
        },
        function (categoriesServiceData) {
            //console.log('failed.');
        });
    }

    $rootScope.$on('$stateChangeStart', 
    function(event, toState, toParams, fromState, fromParams){ 
        if($("#window").data("kendoWindow") != undefined) {
            $("#window").data("kendoWindow").destroy();
        }
    })

}]);
