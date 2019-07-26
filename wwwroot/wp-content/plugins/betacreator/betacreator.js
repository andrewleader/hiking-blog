var betaCreatorModalWrapper;

function showBetaCreator(imgUrl, topoData, onSave) {
  
  // Remove any existing
  removeBetaCreator();
  
  var container = document.createElement('div');
  var buttonSave = document.createElement('button');
  var creator;
  buttonSave.innerText = 'Save';
  buttonSave.disabled = true;
  buttonSave.onclick = () => {
    // Save clicked
    onSave(creator.getData(), creator.getImage());
    tb_remove();
  };
  container.appendChild(buttonSave);
  
  var img = document.createElement('img');
  img.src = imgUrl;
  img.onload = () => {
    var width = img.width;
    var height = img.height;
    
    creator = BetaCreator(img, function () {
        // onReady code
        if (topoData) {
          try {
            creator.loadData(topoData);
          } catch {
            
          }
        }
        buttonSave.disabled = false;
      }, {
        // Settings
        zoom: 'contain',
        width: '100%',
        height: '500px',
        scaleFactor: width / 700
      });
  };
  container.appendChild(img);
  
  
      
  betaCreatorModalWrapper = document.createElement('div');
  betaCreatorModalWrapper.id = 'betaCreatorModalId';
  betaCreatorModalWrapper.appendChild(container);
  document.body.appendChild(betaCreatorModalWrapper);
  
  // https://www.exratione.com/2018/02/the-easiest-javascript-modal-for-administrative-pages-in-wordpress-4/
  tb_show(
    'Edit beta details',
    '#TB_inline?inlineId=' + betaCreatorModalWrapper.id
  );

  // Prevent the window esc keypresses since they bind to esc key to close window, but we need that to end the line drawing
  $(document).off('keypress');
  $(document).off('keydown');
};

function removeBetaCreator() {
  if (betaCreatorModalWrapper) {
    betaCreatorModalWrapper.parentNode.removeChild(betaCreatorModalWrapper);
    betaCreatorModalWrapper = null;
  }
}

/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
( function (blocks, element) {
  
  
  var el = element.createElement;
  
  // Good examples of MediaUpload: https://github.com/WordPress/gutenberg/issues/11470
  
  var MediaUpload = wp.editor.MediaUpload;
  var IconButton = wp.components;
  var creator;
  var modified = false;
  
  blocks.registerBlockType('andrewleader/betacreator', {
    title: 'Betacreator',
    icon: 'smiley',
    category: 'common',
    attributes: {
      imgUrl: {
        type: 'string',
        source: 'attribute',
        selector: 'img',
        attribute: 'src'
      },
      topoData: {
        type: 'string',
        source: 'attribute',
        selector: 'div',
        attribute: 'data-topo'
      },
      topoPng: {
        type: 'string',
        source: 'attribute',
        selector: 'img.beta-img-topo',
        attribute: 'src'
      }
    },

    
    edit: function(props) {
      function onSelectImage(value) {
        props.setAttributes({
          imgUrl: value.url,
          imgId: value.id
        });
        showBetaCreator(value.url, undefined, onBetaCreatorSaved);
        return true;
      }
      
      var openEditor = () => {
        showBetaCreator(props.attributes.imgUrl, props.attributes.topoData, onBetaCreatorSaved);
      }
      
      function onBetaCreatorSaved(topoData, topoPng) {
        props.setAttributes({
          topoData: topoData,
          topoPng: topoPng
        });
      }
      
      return el(
        MediaUpload,
        {
          onSelect: onSelectImage,
          type: 'image',
          value: props.attributes.imgUrl,
          render: function (obj) {
            
            if (props.attributes.imgUrl) {
              return el(
                'div',
                {
                  className: 'beta-img',
                  "data-topo": props.attributes.topoData,
                  onClick: function () {
                    openEditor();
                  }
                },
                el(
                  'img',
                  {
                    className: 'beta-img-original',
                    src: props.attributes.imgUrl
                  }
                ),
                el(
                  'img',
                  {
                    className: 'beta-img-topo',
                    src: props.attributes.topoPng
                  }
                )
              );
            } else {
              obj.open();
              return el(
                'button',
                {
                  type: 'button',
                  onClick: obj.open
                },
                'Choose image'
              );
            }
          }
        }
      );
      
    },
    save: function(props) {
      if (props.attributes.imgUrl) {
        return el(
          'div',
          {
            className: 'beta-img',
            "data-topo": props.attributes.topoData
          },
          el(
            'img',
            {
              className: 'beta-img-original',
              src: props.attributes.imgUrl
            }
          ),
          el(
            'img',
            {
              className: 'beta-img-topo',
              src: props.attributes.topoPng
            }
          )
        );
      } else {
        return el(
          'p',
          {},
          'No image'
        );
      }
    }
  });
}(
  window.wp.blocks,
  window.wp.element
));