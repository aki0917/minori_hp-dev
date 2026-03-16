<?php
/**
 * HowTo 構造化データ
 *
 * ■ 出力条件: HowToデータがセットされたページ（テンプレート側で呼び出し）
 * ■ E-E-A-T: 経験（Experience）・専門性（Expertise）
 * ■ AIO/AEO: 手順付き回答としてAI・Google に直接採用される
 *
 * 農業の実践的な手順（施肥方法、農薬の使い方、栽培ガイド等）を
 * HowTo として構造化することで、AEO 観点で回答ソースになりやすい。
 *
 * @package Minorihp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * HowToデータの格納用
 *
 * @var array
 */
$GLOBALS['minorihp_howto_data'] = array();

/**
 * HowToデータをセット（テンプレートから呼び出す）
 *
 * @param array $howto {
 *   @type string   $name        タイトル（例: 「トマトの育て方」）
 *   @type string   $description 概要説明
 *   @type string   $totalTime   所要時間 ISO 8601 形式（例: 'PT30M', 'P1D'）
 *   @type string   $image       画像URL（任意）
 *   @type array    $supply      材料リスト [ 'name' => string ]（任意）
 *   @type array    $tool        道具リスト [ 'name' => string ]（任意）
 *   @type array    $step        手順リスト [ 'name' => string, 'text' => string, 'image' => string(任意) ]
 * }
 */
function minorihp_set_howto_data( $howto ) {
	if ( ! is_array( $howto ) || empty( $howto['name'] ) || empty( $howto['step'] ) ) {
		return;
	}
	$GLOBALS['minorihp_howto_data'] = $howto;
}

/**
 * HowTo 構造化データを出力
 */
function minorihp_schema_howto() {
	$howto = $GLOBALS['minorihp_howto_data'];

	if ( empty( $howto ) || empty( $howto['step'] ) ) {
		return;
	}

	$steps = array();
	$position = 1;
	foreach ( $howto['step'] as $step ) {
		if ( empty( $step['name'] ) || empty( $step['text'] ) ) {
			continue;
		}

		$step_data = array(
			'@type'    => 'HowToStep',
			'position' => $position,
			'name'     => $step['name'],
			'text'     => wp_strip_all_tags( $step['text'] ),
		);

		if ( ! empty( $step['image'] ) ) {
			$step_data['image'] = $step['image'];
		}

		$steps[] = $step_data;
		$position++;
	}

	if ( empty( $steps ) ) {
		return;
	}

	$data = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'HowTo',
		'name'        => $howto['name'],
		'description' => ! empty( $howto['description'] ) ? $howto['description'] : '',
		'step'        => $steps,
	);

	if ( ! empty( $howto['totalTime'] ) ) {
		$data['totalTime'] = $howto['totalTime'];
	}

	if ( ! empty( $howto['image'] ) ) {
		$data['image'] = $howto['image'];
	}

	if ( ! empty( $howto['supply'] ) && is_array( $howto['supply'] ) ) {
		$data['supply'] = array();
		foreach ( $howto['supply'] as $supply ) {
			$data['supply'][] = array(
				'@type' => 'HowToSupply',
				'name'  => $supply['name'],
			);
		}
	}

	if ( ! empty( $howto['tool'] ) && is_array( $howto['tool'] ) ) {
		$data['tool'] = array();
		foreach ( $howto['tool'] as $tool ) {
			$data['tool'][] = array(
				'@type' => 'HowToTool',
				'name'  => $tool['name'],
			);
		}
	}

	minorihp_output_jsonld( $data );
}
