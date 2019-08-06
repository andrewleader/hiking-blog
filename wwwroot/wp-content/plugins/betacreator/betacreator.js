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

function uuidv4() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
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
      },
      id: { // We need a unique ID for the input label
        type: 'string',
        source: 'attribute',
        selector: 'input',
        attribute: 'id'
      }
    },

    
    edit: function(props) {
      function onSelectImage(value) {

        /*
        Value props
        
        id -> number
        url -> Full resolution
        link -> img_7297/ ??
        icon -> icon url? Although it points to some default icon
        editLink -> Link to edit image
        height -> height in pixels
        width -> width in pixels
        orientation -> "landscape" or "portrait"
        sizes -> object
        	thumbnail -> (150x150)
        		height
        		width
        		url
        		orientation
        	medium -> (300x200)
        	large -> (525x350, but actually gives 1024x683 img)
        	full -> (original)
        	medium_large -> 1152x768
        	post-thumbnail -> (600x450)
        */
        
        var imgUrl = value.url;
        if ("large" in value.sizes) {
         imgUrl = value.sizes.large.url; 
        }

        props.setAttributes({
          imgUrl: imgUrl,
          imgId: value.id,
          id: props.id || uuidv4()
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
      
      if (!props.attributes.id) {
       return el(
         'button',
         {
           type: 'button',
           onClick: () => {
             props.setAttributes({
               id: uuidv4()
             });
           }
         },
         'Up-convert'
       );
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
                  'input',
                  {
                    type: 'checkbox',
                    id: 'show-overlay-' + props.attributes.id,
                    checked: ''
                  }
                ),
                el(
                  'label',
                  {
                    for: 'show-overlay-' + props.attributes.id
                  },
                  'Show overlay'
                ),
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
            'input',
            {
              type: 'checkbox',
              id: 'show-overlay-' + props.attributes.id,
              checked: ''
            }
          ),
          el(
            'label',
            {
              for: 'show-overlay-' + props.attributes.id
            },
            'Show overlay'
          ),
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
