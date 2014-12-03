		<script src="/components/angular/angular.js"></script>
		<script src="/components/angular-animate/angular-animate.js"></script>
		<script src="/components/angular-resource/angular-resource.js"></script>
		<script src="/components/angular-route/angular-route.js"></script>

		<script src="/components/jquery/dist/jquery.js"></script>
		<script src="/components/bootstrap/dist/js/bootstrap.js"></script>
		<script src="/components/classie/classie.js"></script>
		<script src="/components/d3/d3.js"></script>
		<script src="/components/snap.svg/dist/snap.svg.js"></script>
		<script src="/components/topojson/topojson.js"></script>
		<script src="/components/sweetalert/lib/sweet-alert.js"></script>

		<script src="/js/modernizr.custom.js"></script>
		<script src="/js/notificationFx.js"></script> <script src="/js/fullscreen-form.js"></script>
        <script type="text/javascript">
            var Engage = (function () {

                function usermenu() {
                    var wrapper = document.getElementById("Wrapper");
                    classie.removeClass( wrapper, 'inactive');
                    classie.toggleClass( wrapper, 'usermenu');
                }

                function reveal() {
                    var wrapper = document.getElementById("Wrapper");
                    classie.removeClass( wrapper, 'usermenu');
                    classie.toggleClass( wrapper, 'inactive');
                }

                return {
                    "usermenu": usermenu,
                    "reveal": reveal
                }
            })();
        </script>
		<script src="/js/angular-app.js"></script>
