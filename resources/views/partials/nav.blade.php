<section class="widget menus-expandable-widget max-view">
  <div class="menus-widget-container" style="--home-label:'Home';">
    <section class="widget menu-widget">
      <span id="menu-toggle" class="hamburger-menu-block">
        <icon class="hamburger-menu ph ph-list"></icon>
        <span>Select Menu</span>
      </span>
      <ul class="menu-list menu-parent-unordered-list custom-items-center">

        <li class="megamenu-link">
          <a class="menu-parent-list-link home-link" href="{{ url('/') }}"></a>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="About Us" href="#" class="menu-parent-list-link">
            About Us <icon class="menu-parent-list-link-icon ph ph-caret-double-down"></icon>
          </a>
          <div class="mega-menu-dropdown megaMenu">
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>Club Information</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('about') }}"><div>History &amp; Background</div></a>
                </li>
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('about') }}#mission"><div>Mission &amp; Vision</div></a>
                </li>
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('about') }}#organogram"><div>Organogram</div></a>
                </li>
              </ul>
            </div>
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>Leadership</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('members.index') }}"><div>Executive Committee</div></a>
                </li>
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('members.index') }}?type=former"><div>Former Presidents</div></a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="Notices" href="{{ route('notices.index') }}" class="menu-parent-list-link">
            Notices <icon class="menu-parent-list-link-icon ph ph-caret-double-down"></icon>
          </a>
          <div class="mega-menu-dropdown megaMenu">
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>Official Notices</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('notices.index') }}?type=general"><div>General Notices</div></a>
                </li>
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('notices.index') }}?type=tender"><div>Tenders</div></a>
                </li>
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('notices.index') }}?type=recruitment"><div>Recruitment</div></a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="Events" href="{{ route('events.index') }}" class="menu-parent-list-link">
            Events <icon class="menu-parent-list-link-icon ph ph-caret-double-down"></icon>
          </a>
          <div class="mega-menu-dropdown megaMenu">
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>Club Events</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('events.index') }}?type=upcoming"><div>Upcoming Events</div></a>
                </li>
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('events.index') }}?type=past"><div>Past Events</div></a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="Gallery" href="{{ route('gallery.index') }}" class="menu-parent-list-link">
            Gallery <icon class="menu-parent-list-link-icon ph ph-caret-double-down"></icon>
          </a>
          <div class="mega-menu-dropdown megaMenu">
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>Media</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('gallery.index') }}?type=photos"><div>Photo Gallery</div></a>
                </li>
                <li class="menu-sub-child-list">
                  <a class="menu-sub-child-link" href="{{ route('gallery.index') }}?type=videos"><div>Videos</div></a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="News" href="{{ route('news.index') }}" class="menu-parent-list-link">
            News
          </a>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="Contact" href="{{ route('contact') }}" class="menu-parent-list-link">
            Contact
          </a>
        </li>

      </ul>
    </section>
  </div>
</section>
