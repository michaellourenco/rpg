<!--INICO CONTEUDO DO USUARIO -->
<div id="usuario">
        <div id="centro-esquerda">
   			                          
            <div id="bloco-usuario-esquerda">
            	<?=$this->render('/usuario/titulo.phtml'); ?>
            	<?=$this->render('/usuario/dados-item.phtml'); ?> 
            </div>  
            <div id="bloco-usuario-direita">
            	<?=$this->render('/usuario/menu-conteudo.phtml'); ?>
            <!--INICO LISTA DE ESTABELECIMENTOS DO USUARIO -->
            <div class="rel-item-vip">
            <?php if ($this->usuarios->getListaItems()): ?>
                
                <h3>Items</h3>
                        <?php foreach ( $this->usuarios->getListaItems() as $relacao) : ?>
                            <div class='item-vip'>
                              <a href="/item/conteudo/id/<?php echo $relacao->getIdItem(); ?>" title="ver"> <?php echo $this->escape($relacao->getTitulo()); ?></a>            </div>
                        <?php endforeach; ?>
                
            <?php else: ?>
                <h3>Items</h3>
                <p>Voce nao segue items.</p>      
            <?php endif; ?>
            </div>
            <!--FIM LISTA DE ESTABELECIMENTOS DO USUARIO -->    
            </div>          
        </div>

         
    <div id="centro-direita">       
        <?=$this->render('/usuario/mais-usuarios.phtml'); ?>    
    </div>
</div>