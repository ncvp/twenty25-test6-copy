// Custom block editor script

(function(blocks, element) {
	var el = element.createElement;
	blocks.registerBlockType('ncvp/header-menu', {					// xxxx/yyyy matches header.html
		edit: function() {
			return el('div', {
				style: {
					padding: '20px',
					background: '#f0f0f0',
					border: '5px solid #0073aa',
					textAlign: 'center',
					borderRadius: '10px'
				}
			}, 
			   [el('span', {}, 'NCVP header menu derived from Twenty Seventeen')]
			);
		},
		save: function() {
			return null;
		}
	});
})(window.wp.blocks, window.wp.element);
