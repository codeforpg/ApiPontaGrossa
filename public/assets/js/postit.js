
var postit = angular.module('PostIt', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
});
postit.controller('PostItController',function($scope,$http,$window){
    // $scope.title="";
    $scope.postits = [];
    $scope.addPostIt=function(post){
      $scope.postits.push(post)
      /*$http.post('http://localhost:8000/api/v1/postit',post).then(function(response){
        console.log(response);
      })*/
      delete $scope.post
    }
    $scope.abreLink = function() {
        if (1 == 2) {
            $scope.link = 'http://www.google.com.br'
        } else {
            $scope.link = 'http://www.youtube.com.br'
        }
        $window.open($scope.link)
    }
    // console.log(url);
});

postit.directive("postIt",function () {
    return {
        template:" <a href='#'>"+
                "<p><% message %></p>"+
                "</a>",
        scope:{'message':'=message'},
        restrict:"E"
    }
})