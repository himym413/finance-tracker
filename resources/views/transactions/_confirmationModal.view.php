<dialog
  closedby="any"
  aria-labelledby="modalTitle"
  aria-describedby="modalDescription"
  class="m-auto max-w-xl rounded-lg bg-white p-6 shadow-lg backdrop:bg-black/50">
  <div class="flex flex-col gap-4">
    <div class="flex items-start justify-between">
      <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Are you sure you want to delete this transaction?</h2>
      <button
        type="button"
        data-modal-close
        class="cursor-pointer -me-4 -mt-4 rounded-full p-2 text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 focus:ring-offset-white focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:outline-none"
        aria-label="Close">
        <svg
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          class="size-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <p id="modalDescription" class="text-pretty text-gray-700">
      This transaction will be permanently deleted.
    </p>

    <div class="flex justify-end gap-2">
      <form id="deleteForm" method="POST">
        <button
          type="button"
          data-modal-close
          class="cursor-pointer rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
          Cancel
        </button>

        <button
          type="submit"
          class="cursor-pointer rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
          Delete
        </button>

        <input
          type="hidden"
          name="_token"
          value="<?= htmlspecialchars(csrfToken()) ?>">
      </form>
    </div>
  </div>
</dialog>

<script>
  const modalEl = document.querySelector('dialog');
  const deleteForm = document.getElementById('deleteForm');

  document.querySelectorAll('[data-modal-open]').forEach((button) => {
    button.addEventListener('click', () => {
      const id = button.dataset.transactionId;

      deleteForm.action = `/transactions/${id}/delete`;

      modalEl.showModal();
    });
  });

  document.querySelectorAll('[data-modal-close]').forEach((button) => {
    button.addEventListener('click', () => modalEl.close())
  });
</script>