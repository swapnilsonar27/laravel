angular.module('unidbApp')
.service('categoriesService', ['$q', '$http', 'store', 'URL_API', '$rootScope',
	function manageThemesService($q, $http, store, URL_API, $rootScope) {
		var token="Bearer "+store.get('token');
		return {
			getCategories: function () {

				return $http({ 
					method:'GET', 
					url : URL_API.url+'catagory/translation/all',
					headers: {'Authorization' : token},
				}).success(function(getData){
					//console.log(getData.message);
				}).error(function(){
					//console.log("failed");
				});

			},
			
			createCategories: function(addNewData){
				var dfd = $q.defer();
				var createData = addNewData;
			    $http({ method:'POST', 
					url :  URL_API.url+"catagory/translation/save",
					headers: {'Authorization' : token},
					data: createData
				}).success(function(data){
					 dfd.resolve(data);
					//console.log(data);
				}).error(function(){
					 dfd.reject("Failed");
				});
				return dfd.promise
			},
			
			updateCategories: function(updatedData){
				var dfd = $q.defer();
				var updateData = updatedData;
				return $http({ method:'POST', 
					url : URL_API.url + "catagory/translation/update",
					headers: {'Authorization' : token},
					data: updateData
				}).success(function(data){
					 dfd.resolve(data);
					//console.log(data);
				}).error(function(){
					 dfd.reject("Failed");
				});;
				return dfd.promise
			},


			deleteCategoriesById: function(deletedData){
				var dfd = $q.defer();
				 $http({ method:'POST', 
					url :  URL_API.url + "catagory/translation/delete?id="+deletedData.id,
					headers: {'Authorization' : token},
					data: deletedData
				}).success(function(data){
					 dfd.resolve(data);
					//console.log(data);
				}).error(function(){
					 dfd.reject("Failed");
				});
				return dfd.promise
			}
		}
	}]);