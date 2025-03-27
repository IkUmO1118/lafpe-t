function ResultLoading() {
  return (
    <section className="flex w-full flex-col">
      <div className="flex w-3/5 flex-col items-center gap-8 self-center pt-20 pb-14">
        <h1 className="text-5xl font-black text-neutral-900">
          施設性能の診断結果
        </h1>
        <div className="relative flex h-96 w-full justify-between">
          <div className="w-48 opacity-0">hidden</div>
          <div className="h-[240px] w-[240px] animate-pulse self-center rounded-full bg-neutral-300"></div>
          <div className="flex flex-col justify-end gap-5">
            <div className="h-12 w-48 animate-pulse rounded-md bg-neutral-300"></div>
            <div className="h-12 w-48 animate-pulse rounded-md bg-neutral-300"></div>
          </div>
        </div>
      </div>
    </section>
  );
}

export default ResultLoading;
