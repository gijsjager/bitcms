$.extend($.summernote.plugins, {
    'linkclass': function (context) {
        const ui = $.summernote.ui;
        const self = this;
        let savedRange = null;

        // Dialog UI
        this.$dialog = ui.dialog({
            title: 'Insert Link or Button',
            body: `
          <div class="form-group">
            <label>URL</label>
            <input type="text" class="note-link-url form-control" placeholder="http://example.com">
          </div>
          <div class="form-group">
            <label>Link Text</label>
            <input type="text" class="note-link-text form-control" placeholder="My Link">
          </div>
          <div class="form-group">
            <label>Type</label>
            <select class="note-link-type form-control">
              <option value="link">Link</option>
              <option value="button">Button</option>
            </select>
          </div>
          <div class="form-group">
            <label>Target</label>
            <select class="note-link-target form-control">
              <option value="_self">Same tab</option>
              <option value="_blank">New tab</option>
            </select>
          </div>
        `,
            footer: `
          <button href="#" class="btn btn-primary note-insert-link-btn">Insert</button>
        `
        }).render().appendTo('body');

        // Add button to toolbar
        context.memo('button.linkclass', function () {
            return ui.button({
                contents: '<i class="note-icon-link"/>',
                tooltip: 'Insert Link or Button',
                click: function () {
                    savedRange = context.invoke('editor.createRange'); // Save selection
                    self.show();
                }
            }).render();
        });

        // Show dialog
        this.show = function () {
            const $url = self.$dialog.find('.note-link-url');
            const $text = self.$dialog.find('.note-link-text');
            const $type = self.$dialog.find('.note-link-type');
            const $target = self.$dialog.find('.note-link-target');

            $url.val('');
            $text.val('');
            $type.val('link');
            $target.val('_self');

            self.$dialog.one('click', '.note-insert-link-btn', function (event) {
                event.preventDefault();

                const url = $url.val();
                const text = $text.val();
                const type = $type.val();
                const target = $target.val();

                if (url && text) {
                    const $node = $('<a></a>')
                        .attr('href', url)
                        .attr('target', target)
                        .text(text);

                    if (type === 'button') {
                        $node.addClass('btn btn-primary');
                    }

                    ui.hideDialog(self.$dialog);

                    context.invoke('editor.restoreRange', savedRange);
                    context.invoke('editor.focus');
                    context.invoke('editor.insertNode', $node[0]);
                } else {
                    alert('Please enter both a URL and link text.');
                }
            });

            ui.showDialog(self.$dialog);
        };
    }
});