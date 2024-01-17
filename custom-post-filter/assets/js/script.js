(function ($) {
  $(document).ready(function () {
    const filterPostAndTaxonomy = $('.filter-sec .filter-type input[name="post_types"], .filter-type-cat input[name="categories"]');
    const search = $('#custom-search #search-input');
    const pagination = $('.page-numbers');
    const loader = $('.filter-sec .loader');

    // Event listeners
    filterPostAndTaxonomy.change(handleFilterChange);
    search.focusout(handleFilterChange);
    $(document).on('click', '.page-numbers', handlePaginationClick);
    $('#show-all-button').on('click', handleShowAllClick);
    $('#custom-search').on('submit', handleSearchSubmit);

    /**
     * Handles checkbox change, search focusout, and pagination click events.
     */
    function handleFilterChange() {
      removeSelectedPage();
      filterByAjax();
    }

    /**
     * Handles pagination click event.
     *
     * @param {Event} event - The click event.
     */
    function handlePaginationClick(event) {
      event.preventDefault();
      let currentPage = 1;
      let selectedPage = $(this).text();

      if ($('.filter-sec span#selected-page').length) {
        currentPage = $('.filter-sec span#selected-page').text();
        removeSelectedPage();
      }

      if ($(this).hasClass('next')) {
        selectedPage = (+currentPage) + 1;
      }

      if ($(this).hasClass('prev')) {
        selectedPage = (+currentPage) - 1;
      }

      addSelectedPage(selectedPage);
      filterByAjax();
    }

    /**
     * Handles "Show All" button click.
     */
    function handleShowAllClick() {
      removeSelectedPage();
      search.val('').attr('placeholder', 'Type your search...');
      filterPostAndTaxonomy.prop('checked', false);
      filterByAjax();
    }

    /**
     * Handles search form submission.
     *
     * @param {Event} e - The form submission event.
     */
    function handleSearchSubmit(e) {
      removeSelectedPage();
      e.preventDefault();
      filterByAjax();
    }

    /**
     * Adds the selected page to the filter section.
     *
     * @param {string|number} selectedPage - The selected page value.
     */
    function addSelectedPage(selectedPage) {
      const selectedPageHtml = `<span id="selected-page" style="display:none !important;">${selectedPage}</span>`;
      $('.filter-sec').append(selectedPageHtml);
    }

    /**
     * Removes the selected page from the filter section.
     */
    function removeSelectedPage() {
      $('#selected-page').remove();
    }

    /**
     * Filters the data by making an AJAX request and updates the UI accordingly.
     */
    function filterByAjax() {
      const selectedPostType = getSelectedValues('.filter-sec .filter-type input[name="post_types"]');
      const selectedPostTaxonomy = getSelectedValues('.filter-type-cat input[name="categories"]');
      const searchQuery = $('#custom-search #search-input').val();
      // const headerspace = $('.sub-page-header').height(); // class name of header
      const paged = $('.filter-sec span#selected-page').length ? $('.filter-sec span#selected-page').html() : 1;
      const ajaxURL = $('#custom-search input[name="ajax_url"]').val();

      $('.filter-sec .filter-post .posts').html('');
      $('.filter-sec .filter-post .pagination').html('');

      loader.show();

      $.ajax({
        url: ajaxURL,
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'filter_post_by_ajax',
          search: searchQuery,
          paged,
          selectedPostType,
          selectedPostTaxonomy,
        },
        success: function (response) {
          loader.hide();

          $('.filter-sec .filter-post .posts').html(response.html);
          $('.filter-sec .filter-post .pagination').html(response.pagination);

          // $('html, body').animate({
          //   scrollTop: $('.blog-filter-sec').offset().top - headerspace,
          // }, 500);
        },

      });
    }

    /**
     * Retrieves the selected values from checkboxes.
     *
     * @param {string} selector - The selector for the checkboxes.
     * @return {Array} An array containing the selected values.
     */
    function getSelectedValues(selector) {
      const filterElements = $(selector);
      const selectedValues = [];

      filterElements.each((index, element) => {
        const value = $(element).val();
        if ($(element).is(':checked')) {
          selectedValues.push(value);
        } else {
          const valueIndex = selectedValues.indexOf(value);
          if (valueIndex !== -1) {
            selectedValues.splice(valueIndex, 1);
          }
        }
      });

      return selectedValues;
    }
  });
})(jQuery);
