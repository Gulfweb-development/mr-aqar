<!-- Map Modal -->
<div class="modal fade" id="map-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('Select Your Location on Map')}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 550px; width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-air-light" data-dismiss="modal">{{__('Close Without Saving')}}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveAndClose()">{{__('Save and Close')}}</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/select-location-on-map.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnzOm5LfUi_94uz3nPjW-LExL14iqfLmU&callback=initMap" type="text/javascript"></script>
