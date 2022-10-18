const myModal = document.getElementById('modal-delete')
const myInput = document.getElementById('modal-delete')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})
