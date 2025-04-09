function FeedbackHeader() {
  return (
    <div className="flex flex-col gap-14 border-r border-neutral-200 px-24">
      <h1 className="text-5xl font-black text-neutral-800">ご意見・ご感想</h1>
      <ul className="flex flex-col gap-4 text-lg text-neutral-700">
        <li>
          ・本ツールは、利用者のメールアドレスを含む個人及び所属施設に関する一切の情報を収集いたしません。
        </li>
        <li>
          ・頂戴したご意見・ご感想等は、このツールの改修・改善以外の用途には使用いたしません。
        </li>
      </ul>
    </div>
  );
}

export default FeedbackHeader;
