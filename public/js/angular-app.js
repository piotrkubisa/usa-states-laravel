'use strict';

/* App Module */

var ustateApp = angular.module('ustateApp', [
  'ngRoute',
  'ngAnimate',
  // 'ustateAnimations',

  'ustateControllers',
  // 'ustateFilters'
  'ustateServices'
]);

ustateApp.config(function ($interpolateProvider) {
    $interpolateProvider.
    startSymbol('{[').
    endSymbol(']}');
});

/* Controllers */

var ustateControllers = angular.module('ustateControllers', []);

ustateControllers.controller('IntroCtrl', ['$scope',
 function ($scope) {
        $scope.sectionId = 'Intro';
        $scope.usermenu = Engage.usermenu;
        $scope.reveal = Engage.reveal;
        $scope.loginDialog = false;
        $scope.toggleLoginDialog = function($e) {
            if ($scope.loginDialog === true) {
                $scope.loginDialog = false;
            } else {
                $scope.loginDialog = true;
            }
        };
}]);

ustateControllers.controller('MapCtrl', ['$scope', '$routeParams', 'State', '$window', '$location',  '$anchorScroll', 'Score', '$filter',
 function ($scope, $routeParams, State, $window, $location, $anchorScroll, Score, $filter) {
        $scope.sectionId = 'Map';
        $scope.showStateOverview = true;
        $scope.States = State.all();
        $scope.usermenu = Engage.usermenu;
        $scope.reveal = Engage.reveal;
        $scope.loginDialog = false;
        $scope.toggleLoginDialog = function ($e) {
            if ($scope.loginDialog === true) {
                $scope.loginDialog = false;
            } else {
                $scope.loginDialog = true;
            }
        };
        $scope.settingsDialog = false;
        $scope.toggleSettingsDialog = function($e) {
            if ($scope.settingsDialog === true) {
                $scope.settingsDialog = false;
            } else {
                $scope.settingsDialog = true;
            }
        };
        $scope.saveSettingsDialog = function($e) {
            $scope.showStateOverview = document.getElementById('stateOverview').checked;
        }; 

        $scope.is_playing = false;
        $scope.status = "preview";
        $scope.exceptStates = [3, 7, 14, 43, 52];
        $scope.statesToPointOut = [];
        $scope.currentIterator = 0;
        $scope.points = 0;
        $scope.targetPoints = 5;
        $scope.state = 0;
        $scope.statsCounter = 0;
        $scope.startTime = null;
        $scope.diffTime = {
            "hours": 0,
            "minutes": 0,
            "seconds": 0,
            "microseconds": 0
        };
        $scope.drawerStateList = true;
        $scope.pointOut = "";
        $scope.activeStateIndex = -1;
        $scope.activeState = {"id":"","name":"","capital":"","area_mi":0,"area_km":0,"highest_point":" ","highest_point_m":0,"highest_point_ft":0,"img_caption":"","population":0,"created_at":"","updated_at":""};
        
        $scope.closeStateInfo = function() {
            $scope.activeStateIndex = -1;
        };
        
        $scope.showStateInfo = function(stateId) {
            $scope.activeStateIndex = stateId;
            $scope.activeState = $filter('filter')($scope.States, function (d) {
                return d.id == stateId;
            })[0];
        }

        $scope.toggleStateList = function () {
            // var wrapper = document.getElementById( 'Wrapper' );
            // classie.toggle( wrapper, 'drawer-states-closed' );
            if ($scope.drawerStateList == true) {
                $scope.drawerStateList = false;
            } else {
                $scope.drawerStateList = true;
            }
        }

        $scope.selectState = function (event, state_id) {
            var wrapper = document.getElementById('Wrapper');
            var path = document.getElementById('pathState' + state_id);
            var evt = document.createEvent("MouseEvents");
            
            evt.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
            path.dispatchEvent(evt);
        }
        
        $scope.gotoElement = function (eID) {
            $location.hash(eID);
            $anchorScroll();
            $location.hash('');
        };
     
        function notify() {
            var notification = new NotificationFx({
            message: '<span class="ion icon ion-ios7-checkmark"></span><p>Good job!.</p>',
                layout: 'attached',
                effect: 'bouncyflip',
                type: 'notice', // notice, warning or error
                onClose: function () {},
                ttl: 3000
            });

            notification.show();
        }

        $scope.Game = (function () {

            function refresh() {
                var empty = document.getElementById('empty');
                empty.click();
            }

            function isPlaying() {
                return $scope.is_playing;
            }


            function getPoints() {
                return $scope.points;
            }

            function getTargetPoints() {
                return $scope.targetPoints;
            }

            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
                // return (Math.round((max-min) * Math.random() + min));
            }

            function isInt(mixed_var) {
                return mixed_var === +mixed_var && isFinite(mixed_var) && !(mixed_var % 1);
            }

            function setPoints(pt) {
                if (isInt($scope.points)) {
                    $scope.points = pt;
                }
            }
            
            function randStates(number) {
                var arr = [];

                while (arr.length < number) {
                    var randomnumber = getRandomInt(1, 56);
                    var found = false;

                    for (var i = 0; i < arr.length; i++) {
                        if (arr[i] == randomnumber) {
                            found = true;
                            break;
                        }
                    }

                    for (var i = $scope.exceptStates.length - 1; i >= 0; i--) {
                        if ($scope.exceptStates[i] == randomnumber) {
                            found = true;
                            break;
                        }
                    };

                    if (!found) arr[arr.length] = randomnumber;
                }

                return arr;
            }

            function getClue() {
                var currentState = $scope.statesToPointOut[$scope.currentIterator];
                var path = document.getElementById('pathState' + currentState);
                $scope.statsCounter++;
                angular.element(path)
                    .addClass('tada')
                    .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        angular.element(this).removeClass('tada');

                    });

            }

            function setStateToPointOut(stateId) {
                $scope.pointOut = getByStateId(stateId).name;
            }

            function getByStateId(stateId) {
                for (var i = $scope.States.length - 1; i >= 0; i--) {
                    if ($scope.States[i].id == stateId) {
                        return $scope.States[i];
                    };
                };
            }

            function setState(stateId) {
                $scope.state = stateId;
                
                next(stateId);
                refresh()
            }

            function next(stateId) {
                var is_success = check(stateId);
                $scope.statsCounter++;
                //report(stateId);

                if (is_success) {
                    $scope.currentIterator++;
                    $scope.points++;
                    notify();
                    if ($scope.statesToPointOut.length != $scope.currentIterator) {
                        setStateToPointOut($scope.statesToPointOut[$scope.currentIterator]);
                    } else {
                        gameOver();
                    }
                }
            }

            function check(stateId) {
                if ($scope.statesToPointOut[$scope.currentIterator] == stateId) {
                    return true;
                }

                return false;
            }

            function report(stateId) {
                if (jQuery("path[data-stateId=" + stateId + "]").length) {
                    $scope.statsCounter++;
                }
            }
            
            function reportScore(endTime) {
                Score.save({
                    'targetPoints': $scope.targetPoints,
                    'guesses': $scope.statsCounter,
                    'start_time': $scope.startTime,
                    'end_time': endTime
                })
            }

            function gameOver() {
                var now = new Date();

                if (now < $scope.startTime) {
                    now.setDate(now.getDate() + 1);
                }

                var diff = now - $scope.startTime;

                var msec = diff;
                var hh = Math.floor(msec / 1000 / 60 / 60);
                msec -= hh * 1000 * 60 * 60;
                var mm = Math.floor(msec / 1000 / 60);
                msec -= mm * 1000 * 60;
                var ss = Math.floor(msec / 1000);
                msec -= ss * 1000;

                $scope.diffTime = {
                    "hours": hh,
                    "minutes": mm,
                    "seconds": ss,
                    "microseconds": msec
                };

                if ($scope.points == $scope.targetPoints) {
                    var swalText = 'You did ' + $scope.statsCounter + ' guesses to point out ' + $scope.targetPoints + ' states on the map. It took ' + $scope.diffTime.minutes + 'm ' + $scope.diffTime.seconds + '.' + $scope.diffTime.microseconds + 's.';
                    swal("Good job!", swalText, "success");
                    
                    reportScore(now);
                }

                $scope.is_playing = false;
                $scope.status = "preview";
                setPoints(0);
                $scope.pointOut = "";
                refresh();
            }

            function changeState() {
                if ($scope.is_playing) {
                    return stop();
                }

                return play();
            }

            function setTargetPoints(target) {
                if ($scope.is_playing) {
                    if (confirm("Would you like to change the number of states to point out? Notice: The game will be reseted.")) {
                        $scope.targetPoints = target;
                        play();
                    }
                }
            }

            function play() {
                $scope.is_playing = true;
                $scope.status = "game";
                $scope.startTime = new Date();
                setPoints(0);
                $scope.currentIterator = 0;
                $scope.statsCounter = 0;
                $scope.statesToPointOut = randStates($scope.targetPoints);
                setStateToPointOut($scope.statesToPointOut[$scope.currentIterator]);
            }

            function stop() {
                swal({
                    title: "Are you sure?",
                    text: "You will lose your game state!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, I'd like to stop!",
                    closeOnConfirm: false
                }, function () {
                    $scope.is_playing = false;
                    $scope.status = "preview";
                    setPoints(0);
                    $scope.pointOut = "";

                    swal("Gameover", '', 'error');
                    refresh();
                });
            }

            function toggle() {
                if ($scope.is_playing) {
                    stop();
                } else {
                    play();
                }
            }

            return {
                "play": play,
                "toggle": toggle,
                "isPlaying": isPlaying,
                "stop": stop,
                "refresh": refresh,
                "setPoints": setPoints,
                "getPoints": getPoints,
                "getTargetPoints": getTargetPoints,
                "setTargetPoints": setTargetPoints,
                "setState": setState,
                "getClue": getClue,
                "changeState": changeState
            };
        })();

}]);

ustateControllers.controller('SignupCtrl', ['$scope',
 function ($scope) {
        $scope.sectionId = 'Signup';
        $scope.usermenu = Engage.usermenu;
        $scope.reveal = Engage.reveal;
        $scope.loginDialog = false;
        $scope.toggleLoginDialog = function ($e) {
            if ($scope.loginDialog === true) {
                $scope.loginDialog = false;
            } else {
                $scope.loginDialog = true;
            }
        };
        $scope.errorPasswordMsg = '';

        // initialize FForm
        (function () {
            var formWrap = document.getElementById('fs-form-wrap');
            new FForm(formWrap, {
                onReview: function () {
                    var app = document.getElementById("App");
                    classie.addClass(app, 'overview-bg');
                }
            });
        })();

}]);

ustateControllers.controller('HighscoresCtrl', ['$scope', 'Score',
 function ($scope, Score) {     
        $scope.sectionId = 'Highscores';
        $scope.usermenu = Engage.usermenu;
        $scope.reveal = Engage.reveal;
        $scope.loginDialog = false;
        $scope.toggleLoginDialog = function($e) {
            if ($scope.loginDialog === true) {
                $scope.loginDialog = false;
            } else {
                $scope.loginDialog = true;
            }
        };
        $scope.tabId = 0;
        $scope.scores = Score.query();
     
        $scope.downloadDialog = false;
        $scope.toggleDownloadDialog = function($e) {
            if ($scope.downloadDialog === true) {
                $scope.downloadDialog = false;
            } else {
                $scope.downloadDialog = true;
            }
        };
        
}]);

ustateApp.directive('ngUsmap', function ($window) {
    return {
        restrict: 'EA',
        scope: {
            data: "="
        },
        transclude: true,
        require: "^ngController",
        link: function (scope, iElement, iAttrs, ngCtrl) {

            var width = window.innerWidth - 8,
                height = window.innerHeight - 70;

            scope.active = d3.select(null);
            scope.svg = d3.select(iElement[0]).append("svg")
                .attr("width", width)
                .attr("height", height)
                .attr("height", height)
                .on("click", stopped, true);

            var bg = scope.svg.append("rect");
            var g = scope.svg.append("g");

            var projection = d3.geo.albersUsa()
                .scale(1000)
                .translate([width / 2, height / 2]);

            var zoom = d3.behavior.zoom()
                .translate([0, 0])
                .scale(1)
                .scaleExtent([1, 8])
                .on("zoom", zoomed);

            var path = d3.geo.path()
                .projection(projection);

            bg
                .attr("class", "background")
                .attr("width", window.innerWidth - 8)
            .attr("height", window.innerHeight - 70)
            .on("click", reset);

            scope.svg
                .call(zoom)
                .call(zoom.event);


            d3.json("/rest/map", function (error, us) {
                g.selectAll("path")
                    .data(topojson.feature(us, us.objects.states).features)
                    .enter().append("path")
                    .attr("id", function (d) {
                        return "pathState" + d.id;
                    })
                    .attr("d", path)
                    .attr("class", "feature")
                    .on("click", clicked);

                g.append("path")
                    .datum(topojson.mesh(us, us.objects.states, function (a, b) {
                        return a !== b;
                    }))
                    .attr("class", "mesh")
                    .attr("d", path);
            });

            /// onresize
            $window.onresize = function () {
                return scope.$apply();
            };

            scope.$watch(function (scope) {
                return angular.element(window)[0].innerWidth + angular.element(window)[0].innerHeight;
            }, function () {
                return scope.render(scope.data);
            });

            scope.$watch('data', function (newVals, oldVals) {
                return scope.render(newVals);
            }, true);

            scope.render = function (data) {
                scope.svg
                    .attr("width", window.innerWidth - 8)
                    .attr("height", window.innerHeight - 70);
                bg
                    .attr("width", window.innerWidth - 8)
                    .attr("height", window.innerHeight - 70);
            };

            function zoomed() {
                g.style("stroke-width", 1.5 / d3.event.scale + "px");
                g.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
            }

            function stopped() {
                if (d3.event.defaultPrevented) d3.event.stopPropagation();
            }

            function reset() {
                scope.active.classed("active", false);

                // reset drawer links
                if (!scope.is_playing) {
                    var drawerAnchors = document.querySelectorAll(".drawer-states-list a");
                    if (drawerAnchors && drawerAnchors.length) {
                        for (var i = drawerAnchors.length - 1; i >= 0; i--) {
                            classie.removeClass(drawerAnchors[i], 'active');
                        }
                    }
                }

                scope.active = d3.select(null);
                scope.$parent.Game.setState(0);

                scope.svg.transition()
                    .duration(750)
                    .call(zoom.translate([0, 0]).scale(1).event);
            }

            function clicked(d) {
                if (!scope.$parent.is_playing) {
                    scope.$parent.showStateInfo(d.id);
                    scope.$parent.Game.refresh();
                }
                
                if (scope.active.node() === this) return reset();

                scope.active.classed("active", false);
                scope.active = d3.select(this).classed("active", true);

                var bounds = path.bounds(d),
                    dx = bounds[1][0] - bounds[0][0],
                    dy = bounds[1][1] - bounds[0][1],
                    x = (bounds[0][0] + bounds[1][0]) / 2,
                    y = (bounds[0][1] + bounds[1][1]) / 2,
                    scale = .7 / Math.max(dx / width, dy / height),
                    translate = [width / 2 - scale * x, height / 2 - scale * y];

                scope.svg.transition()
                    .duration(750)
                    .call(zoom.translate(translate).scale(scale).event);

                if (!scope.$parent.is_playing) {
                    var drawerAnchors = document.querySelectorAll(".drawer-states-list a");
                    if (drawerAnchors && drawerAnchors.length) {
                        for (var i = drawerAnchors.length - 1; i >= 0; i--) {
                            classie.removeClass(drawerAnchors[i], 'active');
                        }
                    }

                    scope.$parent.gotoElement('StateAnchor' + (d.id).toString());

                    var activeAnchor = document.getElementById("StateAnchor" + d.id);
                    classie.addClass(activeAnchor, 'active');
                    
                } else {
                    scope.$parent.Game.setState(d.id);
                }
            }
        }
    };
});

// https://github.com/zemirco/ng-signup-form/blob/master/public/js/script.js
ustateApp.directive('uniqueUsername', ['$http',
    function ($http) {
        return {
            require: 'ngModel',
            link: function (scope, elem, attrs, ctrl) {
                scope.busyUsername = false;
                scope.$watch(attrs.ngModel, function (value) {

                    // hide old error messages
                    ctrl.$setValidity('errorMsg', true);
                    scope.errorUsernameMsg = '';


                    if (!value) {
                        return;
                    }

                    scope.busyUsername = true;
                    $http.post('/rest/check/username', {
                        username: value
                    })
                        .success(function (data) {
                            // everything is fine -> do nothing
                            scope.busyUsername = false;
                            scope.errorUsernameMsg = '';
                        })
                        .error(function (data) {


                            // display new error message
                            if (data.response) {
                                ctrl.$setValidity('errorMsg', false);
                            }
                            scope.busyUsername = false;
                            scope.errorUsernameMsg = data.response;
                        });
                })
            }
        }
}]);

ustateApp.directive('uniqueEmail', ['$http',
    function ($http) {
        return {
            require: 'ngModel',
            link: function (scope, elem, attrs, ctrl) {
                scope.busyEmail = false;
                scope.$watch(attrs.ngModel, function (value) {

                    // hide old error messages
                    ctrl.$setValidity('errorMsg', true);
                    scope.errorEmailMsg = '';

                    if (!value) {
                        return;
                    }

                    scope.busyEmail = true;
                    $http.post('/rest/check/email', {
                        email: value
                    })
                        .success(function (data) {
                            // everything is fine -> do nothing
                            scope.busyEmail = false;
                            scope.errorEmailMsg = '';
                        })
                        .error(function (data) {
                            // display new error message
                            if (data.response) {
                                ctrl.$setValidity('errorMsg', false);

                            }
                            scope.busyEmail = false;
                            scope.errorEmailMsg = data.response;
                        });
                })
            }
        }
}]);

// http://codepen.io/brunoscopelliti/pen/ECyka
ustateApp.directive('match', [

    function () {
        return {
            require: 'ngModel',
            link: function (scope, elem, attrs, ctrl) {

                scope.$watch('[' + attrs.ngModel + ', ' + attrs.match + ']', function (value) {
                    ctrl.$setValidity('match', (value[0] === value[1]) && (value[0] && value[0].length >= 8));
                }, true);

            }
        }
}]);

/* Filters */

// angular.module('ustateFilters', []).filter('checkmark', function() {
//   return function(input) {
//     return input ? '\u2713' : '\u2718';
//   };
// });

/* Services */

var ustateServices = angular.module('ustateServices', ['ngResource']);

ustateServices.factory('State',
    function ($resource) {
        return $resource('/rest/states', {}, {
            // Methods of model
            all: {
                method: 'GET',
                params: {},
                isArray: true
            }
        });
    }
);

ustateServices.factory('Score',
    function ($resource) {
        return $resource("/rest/scores", {}, {
            query: { method: "GET", isArray: true }
        });
});


/* Routes */

ustateApp.config(['$routeProvider',
 function ($routeProvider) {
        $routeProvider.
        when('/', {
            templateUrl: 'partials/intro',
            controller: 'IntroCtrl'
        }).
        when('/map', {
            templateUrl: 'partials/map',
            controller: 'MapCtrl'
        }).
        when('/signup', {
            templateUrl: 'partials/signup',
            controller: 'SignupCtrl'
        }).
        when('/highscores', {
            templateUrl: 'partials/highscores',
            controller: 'HighscoresCtrl'
        }).
        otherwise({
            redirectTo: '/'
        });
 }
]);