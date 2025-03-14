function FeedbackHeader() {
  return (
    <div className="flex flex-col gap-14 border-r border-neutral-200 px-24">
      <h1 className="text-5xl font-black text-neutral-800">ご意見・ご感想</h1>
      <p className="text-lg text-neutral-700">
        ・ご意見、感想などはメールアドレスを収集しません。
        <br />
        ・この診断ツールの改修・改善以外に情報は使用されません。
      </p>
    </div>
  );
}

export default FeedbackHeader;
