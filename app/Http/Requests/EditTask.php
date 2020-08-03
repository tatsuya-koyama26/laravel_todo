<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
// EditTask クラスは CreateTask クラスを継承しています。
// タスクの作成と編集では状態欄の有無が異なるだけでタイトルと期限日は同一なので重複を避けるために継承を用いました
{
    public function rules()
    {
        $rule = parent::rules();

        $status_rule = Rule::in(array_keys(Task::STATUS));
        // 状態欄の入力値が許可されているか（許可リストに含まれているか）検証する in ルールを使用
        // -> 'in(1, 2, 3)' を出力する
        // 後ろから読めばなんとなく分かる、
        // Taskモデルで定義したSTATUS配列のキーをルールとして指定する

        return $rule + [
            'status' => 'required|' . $status_rule,
            // 結果として出力されるルールは以下のようになります
            // 'status' => 'required|in(1, 2, 3)',
        ];
    }

    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        $messages = parent::messages();

        $status_labels = array_map(function($item) {
            return $item['label'];
        }, Task::STATUS);

        $status_labels = implode('、', $status_labels);

        return $messages + [
            'status.in' => ':attribute には ' . $status_labels. ' のいずれかを指定してください。',
        ];
    }
    // ここでは Task::STATUS から status.in ルールのメッセージを作成しています。
    // Task::STATUS の各要素から label キーの値のみ取り出して作った配列をさらに句読点でくっつけて文字列を作成しています。
    // 最終的に「状態 には 未着手、着手中、完了 のいずれかを指定してください。」というメッセージが出来上がります。
}
