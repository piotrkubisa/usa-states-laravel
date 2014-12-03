<div class="dialog in" id="DialogDownload" ng-show="downloadDialog">
    <div class="dialog-container">
        <div class="dialog-content">
            <div class="dialog-header">
                <button type="button" class="close" ng-click="toggleDownloadDialog()">
                    <span aria-hidden="true"><i class="ion ion-ios7-close-outline" style="font-size: 143%"></i></span><span class="sr-only">Close</span>
                </button>
                <h4 class="dialog-title text-center">Download file</h4>
            </div>
            <div class="dialog-body">
                <div class="text-center">
                    <a class="download-link" href="/render/pdf">
                        <i class="ion ion-document"></i>
                        <div><span class="label">PDF</span></div>
                    </a>
                    <a class="download-link" href="/render/xls">
                        <i class="ion ion-document"></i>
                        <div><span class="label">XLS</span></div>
                    </a>
                    <a class="download-link" href="/render/xlsx">
                        <i class="ion ion-document"></i>
                        <div><span class="label">XLSX</span></div>
                    </a>
                </div>
            </div>
            <div class="dialog-footer">
                <button class="btn btn-primary" ng-click="toggleDownloadDialog()" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
