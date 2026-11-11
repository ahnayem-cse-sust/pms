/* Searchable select – same look and behaviour as the Category picker on the equipment page.
   The real <select> stays in the form (hidden, so required / name / onchange keep working);
   a button + search box sit on top of it.  window.searchableSelect(select, emptyLabel) */
(function () {
    window.searchableSelect = function (sel, emptyLabel) {
        if (!sel || sel.dataset.ssDone) return;
        sel.dataset.ssDone = '1';
        emptyLabel = emptyLabel || 'Select…';
        var wrap = document.createElement('div'); wrap.className = 'ss';
        sel.parentNode.insertBefore(wrap, sel); wrap.appendChild(sel);
        sel.classList.add('ss-native'); sel.tabIndex = -1;
        var btn = document.createElement('button'); btn.type = 'button'; btn.className = 'form-select form-select-sm ss-btn';
        var panel = document.createElement('div'); panel.className = 'ss-panel'; panel.hidden = true;
        var box = document.createElement('input'); box.type = 'search'; box.className = 'form-control form-control-sm'; box.placeholder = 'Search name or code…'; box.autocomplete = 'off';
        var list = document.createElement('div'); list.className = 'ss-list';
        panel.appendChild(box); panel.appendChild(list); wrap.appendChild(btn); wrap.appendChild(panel);
        var hl = -1;

        function label() {
            var o = sel.selectedOptions[0], has = o && o.value;
            btn.textContent = has ? o.textContent.trim() : emptyLabel;
            btn.classList.toggle('ss-placeholder', !has);
        }
        function items() { return list.querySelectorAll('.ss-item'); }
        function mark(i) {
            var its = items(); if (!its.length) return;
            hl = (i + its.length) % its.length;
            its.forEach(function (x, k) { x.classList.toggle('hl', k === hl); });
            its[hl].scrollIntoView({ block: 'nearest' });
        }
        function render() {
            var q = box.value.trim().toLowerCase(), shown = 0;
            list.innerHTML = ''; hl = -1;
            if (sel.dataset.ssClear && !q) {   // opt-in: a first entry that clears the choice (the select's empty option)
                var c = document.createElement('div'); c.className = 'ss-item ss-clear' + (sel.value ? '' : ' active'); c.dataset.v = '';
                var cs = document.createElement('span'); cs.textContent = emptyLabel; c.appendChild(cs); list.appendChild(c); shown++;
            }
            Array.prototype.forEach.call(sel.options, function (o) {
                if (!o.value) return;
                var txt = o.textContent.trim();
                if (q && txt.toLowerCase().indexOf(q) < 0) return;
                var it = document.createElement('div'), a = document.createElement('span');
                it.className = 'ss-item' + (o.selected ? ' active' : ''); it.dataset.v = o.value;
                a.textContent = txt; it.appendChild(a); list.appendChild(it);
                shown++;
            });
            if (!shown) { var n = document.createElement('div'); n.className = 'ss-none'; n.textContent = 'Nothing matches.'; list.appendChild(n); }
            var cur = list.querySelector('.ss-item.active'); if (cur && !q) mark(Array.prototype.indexOf.call(items(), cur));
        }
        function open() { panel.hidden = false; box.value = ''; render(); box.focus(); }
        function close() { panel.hidden = true; }
        function pick(v) { sel.value = v; sel.dispatchEvent(new Event('change', { bubbles: true })); label(); close(); btn.focus(); }

        btn.addEventListener('click', function () { panel.hidden ? open() : close(); });
        btn.addEventListener('keydown', function (e) { if (e.key === 'ArrowDown' || e.key === 'ArrowUp') { e.preventDefault(); open(); } });
        box.addEventListener('input', function () { render(); mark(0); });
        box.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') { e.preventDefault(); mark(hl + 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); mark(hl - 1); }
            else if (e.key === 'Enter') { e.preventDefault(); var its = items(); if (its[hl < 0 ? 0 : hl]) pick(its[hl < 0 ? 0 : hl].dataset.v); }
            else if (e.key === 'Escape') { e.preventDefault(); close(); btn.focus(); }
        });
        list.addEventListener('mousedown', function (e) { var it = e.target.closest('.ss-item'); if (it) { e.preventDefault(); pick(it.dataset.v); } });
        function away(e) {
            if (!wrap.isConnected) { document.removeEventListener('mousedown', away); return; }   // line was removed
            if (!wrap.contains(e.target)) close();
        }
        document.addEventListener('mousedown', away);
        sel.addEventListener('ss:refresh', label);   // call after changing the select from code
        label();
    };
})();
