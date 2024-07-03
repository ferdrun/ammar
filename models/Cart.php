<?php
 

class Cart extends model {

	public function getList() {
		$products = new Products();

		$array = array();
		$cart = array();

		if(isset($_SESSION['cart'])) {
			$cart = $_SESSION['cart'];
		}

		foreach($cart as $id => $qt) {

			$info = $products->getInfo($id);

			$array[] = array(
				'id' => $id,
				'qt' => $qt,
				'price' => $info['price'],
				'name' => $info['name'],
				'image' => $info['image'],
				'weight' => $info['weight'],
				'width' => $info['width'],
				'height' => $info['height'],
				'length' => $info['length'],
				'diameter' => $info['diameter']
			);

		}

		return $array;
	}

	public function getSubtotal() {
		$list = $this->getList();

		$subtotal = 0;

		foreach($list as $item) {
			$subtotal += (floatval($item['price']) * intval($item['qt']));
		}

		return $subtotal;
	}

	public function shippingCalculate($cepDestination) {
		global $config;

		$array = array(
			'price' => 0,
			'date' => '',
		);

		global $config;


		$list = $this->getList();
		$nVlId = 0;
		$nVlPeso = 0;
		$nVlComprimento = 0;
		$nVlAltura = 0;
		$nVlLargura = 0;
		$nVlDiametro = 0;
		$nVlValorDeclarado = 0;
		$nVlQt = 0;

		foreach($list as $item) {
			$nVlId = $item['id'];
			$nVlName = $item['name'];
			$nVlPeso += floatval($item['weight']);
			$nVlComprimento += floatval($item['length']);
			$nVlAltura += floatval($item['height']);
			$nVlLargura += floatval($item['width']);
			$nVlDiametro += floatval($item['diameter']);
			$nVlValorDeclarado += floatval($item['price'] * $item['qt']);
			$nVlQt = $item['qt'];
		}

		$soma = $nVlComprimento + $nVlAltura + $nVlLargura;
		if($soma > 200) {
			$nVlComprimento = 66;
			$nVlAltura = 66;
			$nVlLargura = 66;
		}

		if($nVlDiametro > 90) {
			$nVlDiametro = 90;
		}

		if($nVlPeso > 40) {
			$nVlPeso = 40;
		}

		
		 // Instancia o objeto
			$MelhorEnvio = new \MelhorEnvio\MelhorEnvio;
			 
		
			$MelhorEnvio->activeSandbox();

			$MelhorEnvio->setAccessToken("eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NTYiLCJqdGkiOiIzOWM3NGE3MGI4YzJjZDA2ZGRhNjdhZThkMWJlYjk1NTBhNjFmMzZhMzg3MjhhZGM1MDI0NDUzNmQ2NzAxOGMxMDkxOTMwMTdlNGYzNTA1ZCIsImlhdCI6MTcxOTg0MDc0My4zNzI4MzgsIm5iZiI6MTcxOTg0MDc0My4zNzI4NDEsImV4cCI6MTc1MTM3Njc0My4zNjA4MjMsInN1YiI6IjljNDcwYmQxLTUyMmYtNDE3Mi04YmQzLWU1ZTMyMThhMDBhMSIsInNjb3BlcyI6WyJzaGlwcGluZy1jYWxjdWxhdGUiXX0.RkBMmX3BCmcox5QT1PsV-8KShODmgZ1Yfed4X5MheJAq8JSwECPayBib3ZZBOEHpahmnym4OkfxyHF5KWWUoCKkWfyqVqObSnd3ZJRcp6mEwWh4N7fPdvrU8b-JWz0Wq52Cel7tDDu0VO-bHW2LJuQ3ymDKVmp8MRn7qEeqD4gQ8agR3BKtKIs2NRcpSKL1V9o3aRo6wSaLD9C5A5e685Hz7OFJi0JiWHVAxOQSWis6x1kJpwFkXTy-wXYW2HhU5E2Oaziz3xKrd0sWxrfsgWcOvJ9UfOabX0Hedgfboiu94V_LVuGif32F0_HMN1EmncBXLj2iEXaHy9GJOzz_do_d_IGWVwmhGTp4_3CBBer9Ay7bqouonyX1zhkEuLlo-Hgpy73Cxd-mNDSxJFSb-s1o9NcsKsgOg28Noh8WpYybwc1YhZeJoJ867TTxBDY_y_NwhwjV6JXLwlF0M-ShVVIPcjvBKB6weG8O87-5MS0hQXivT_rhDPz5MGQEHqYsFeEc9RWvfBPxjKCln85VgpQ_6Bjd2MBG6TDyd9rIRu8h8yxQVbsHMXGzAdw5f2D20IrPF6lNBQw4woBoVO02q2k5M_JQ3ZOLMGxbEZ3CJx5Xrry4TEzVucw7sywmBgX8pcmIfrSsyDcCw9cUxiDQ0Yr4TTQeeRZGwxRBpHIO1Exg");

			$Product = new MelhorEnvio\Product();

			$Product->setProducts(
				$nVlId,
				$nVlName,
				$nVlLargura,
				$nVlAltura,
				$nVlComprimento,
				$nVlPeso,
				$nVlValorDeclarado,
				$nVlQt

			);
			
			// Realiza o calculo do frete
		$resposta = $MelhorEnvio->calculate($config['cep_origin'], $cepDestination, $Product);

		// Verifica se deu certo
		if(!$resposta["error"]){
			// As informações do frete estão no array 
			$resposta["data"];
			
		}
		print_r($resposta);
	}
}
	

	

		 