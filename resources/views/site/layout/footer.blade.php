    <footer class="mt-4">
        <div class="px-3">
            <div class="theme-container">
                <div class="py-4 content">
                    <div class="row between-xs">
                        <div class="col-xs-12 col-sm-6 sm:mx-auto d-flex align-items-end">
                            <a href="{{ route('Main.index', ['locale' => app()->getLocale()]) }}" class="logo sm:mx-auto">
                                <img src="{{ asset('images/main/logo_footer_' . app()->getLocale() . '.png') }}" style="max-width: 275px;" id="logo_footer" alt="image">
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 sm:mx-auto">
                            @include('site.sections.socials', [
                                'classes' => 'start-xs middle-xs desc sm:justify-content-center end-sm',
                                'icon_classes' => 'mat-icon-md'
                            ])
                        </div>
                    </div>
                </div>
                <div class="between-xs center-lg center-md center-sm center-xs centered copyright middle-xs my-2 row">
                    @if (app()->getLocale()=='en')
                        <p>Copyright {{date('Y')}} | All rights reserved.</p>
                    @else
                        <p> حقوق النشر {{date('Y')}} | كل الحقوق محفوظة.</p>
                    @endif
                </div>
            </div>
        </div>
    </footer>
    <div id="favorites-snackbar" class="mdc-snackbar">
        <div class="mdc-snackbar__surface">
            <div class="mdc-snackbar__label">The property has been added to favorites.</div>
            <div class="mdc-snackbar__actions">
                <button type="button" class="mdc-button mdc-snackbar__action">
                    <div class="mdc-button__ripple"></div>
                    <span class="mdc-button__label">
                        <i class="material-icons warn-color">close</i>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div id="back-to-top"><i class="material-icons">arrow_upward</i></div>
    @include('site.layout.js')
    </body>
</html>
