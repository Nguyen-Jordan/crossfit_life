import './styles/app.scss';
import 'datatables.net';
import 'datatables.net-bs4';

$("#datatable").DataTable();

var $collectionHolder;

var $addNewItem = $('<a href="#" class="btn btn-info">Add new item</a>');

$(document).ready(function () {
  // récupérer collectionHolder
  $collectionHolder = $('#droit_list');

  // ajout bouton retirer élément existant
});