<?php
ob_start();
?>
            <?php MensajesFlash::imprimir_mensajes(); ?>

            <?php foreach ($mis_items as $a): ?>
                <div class="item_listado">
                    <div class="titulo_item"><a href="ver_item/<?= $a->getId() ?>"><?= $a->getTitulo() ?></a></div>
                    <?php if(count($a->getPhotos())>=1): ?>
                        <div class="photos_item" style="background-image:url('<?= RUTA?>web/images/items/<?= $a->getPhotos()[0]->getNombre_archivo() ?>')"></div>
                    <?php else: ?>
                        <div class="photos_item" style="background-image:url('<?= RUTA?>web/images/item_generico.jpg')"></div>
                    <?php endif; ?>
                    <div class="descripcion_item"><?= substr($a->getDescripcion(), 0, 20) . "..." ?></div>
                    <div class="precio_item"><?= $a->getPrecio() ?> €</div>
                    <div class="contactar">CONTACTAR</div>
                    <div class="fecha_item"><?= $a->getFecha() ?></div>
                    <?= $a->getUsuario()->getNombre(); ?>
                    <?php if (Session::existe() && $a->getUsuario()->getId() == (Session::obtener())->getId()): ?>
                        <div class="borrar_item"><a href="<?= RUTA?>borrar_item/<?= $a->getId() ?>/<?=$token ?>"><img src="<?= RUTA?>web/images/icons/trash.svg" class="papelera"></a></div>
                            <?php endif; ?>

                </div>
            <?php endforeach; ?>
 <?php
 $contenido = ob_get_clean();
 $titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
 $titulo2 = "Detalle de items";
 require '../app/views/template.php';

 ?>