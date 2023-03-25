'use strict';

(function () {
  let Tabs = function ($el) {
    let that = this;

    that.$el = $el;
    that.$tabs = [];
    that.$panes = [];

    that.$el.querySelectorAll('li').forEach(($item) => {
      that.$tabs.push($item);
      that.$panes.push(document.getElementById($item.dataset['pane']));

      $item.onclick = function (event) {
        event.preventDefault();

        that.$panes.forEach(($pane) => {
          if ($pane.id === $item.dataset['pane']) {
            $pane.classList.add('active');
          }
          else {
            $pane.classList.remove('active');
          }
        });

        that.$tabs.forEach(($tab) => {
          if ($tab !== $item) {
            $tab.classList.remove('active');
          }
          else {
            $tab.classList.add('active');
          }
        });
      };
    });
  };

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.wcus-tabs').forEach(($el) => {
      new Tabs($el);
    });
  });
})();