var app = angular.module('employeesApp', [],function($interpolateProvider)
{
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>'); 
});

app.controller('employeesController', function($scope,$http) {

    $scope.refreshInbox = function() {
        location.href = '/inbox';
    }
    $scope.refreshSent = function() {
        location.href = '/sent';
    }
    $scope.refreshDeleted = function() {
        location.href = '/deleted';
    }



    $scope.checkForDelete = false;

    $scope.selectForDelete = function(){
        $scope.checkForDelete = true;
    }

    $scope.deleteMailsArray = []
    $scope.fillArrayWithMailsToDelete = function(inbox_id){
        var hasSuchElement=false;
        
        if($scope.deleteMailsArray.length>0){
            for(var i = 0;i<$scope.deleteMailsArray.length;i++){
                if($scope.deleteMailsArray[i] == inbox_id){
                    hasSuchElement=true;
                }
            }
        }
        
        if(hasSuchElement==true){
            $scope.deleteMailsArray.forEach(function(item, index, object) {
                if (item === inbox_id) {
                  object.splice(index, 1);
                }
              });
        }
        else{
            $scope.deleteMailsArray.push(inbox_id);
            
        }
        
        console.log('Array',$scope.deleteMailsArray)
        console.log('LENGTH',$scope.deleteMailsArray.length)
        if($scope.deleteMailsArray.length>0){
            $scope.checkForDelete = true;
        }
        else{
            $scope.checkForDelete = false;
        }
    }

    $scope.deleteMail = function(){
        if (confirm(" Are you sure you want to delete this email?") == true) {
            $http({method: 'POST', url: '/delete-inboxes', data : {'inbox_ids' : $scope.deleteMailsArray}})
        .then(function mySuccess(response) {
            location.href = '/inbox'
        });
        }
    }
    $scope.deleteThisInboxMail = function(inbox_id){
        if (confirm(" Are you sure you want to delete this email?") == true) {
            $http.get("/delete-inbox/"+inbox_id)
        .then(function mySuccess(response) {
            location.href = '/inbox'
        });
        }
    }

    $scope.deleteSentMail = function(){
        if (confirm(" Are you sure you want to delete this email?") == true) {
            $http({method: 'POST', url: '/delete-sents', data : {'inbox_ids' : $scope.deleteMailsArray}})
        .then(function mySuccess(response) {
            location.href = '/sent'
        });
        }
    }

    $scope.deleteThisSentMail = function(inbox_id){
        console.log('ID',inbox_id)
        if (confirm(" Are you sure you want to delete this email?") == true) {
            $http.get("/delete-sent/"+inbox_id)
            .then(function mySuccess(response) {
            location.href = '/sent'
            });
        }
    }

    $scope.removeMail = function(){
        if (confirm(" Are you sure you want to delete this email?") == true) {
            $http({method: 'POST', url: '/remove-inboxes', data : {'inbox_ids' : $scope.deleteMailsArray}})
        .then(function mySuccess(response) {
            location.href = '/deleted'
        });
        }
    }
    $scope.removeThisInboxMail = function(inbox_id){
        if (confirm(" Are you sure you want to delete this email? This will be deleted permanently!") == true) {
            $http.get("/remove-inbox/"+inbox_id)
        .then(function mySuccess(response) {
            location.href = '/deleted'
        });
        }
    }

    

    



    
});