import React, { useState, useEffect, useRef } from "react";

const Header: React.FC = () => {
  const [stickyVisible, setStickyVisible] = useState(false);
  const normalHeaderRef = useRef<HTMLElement | null>(null);

  useEffect(() => {
    const handleScroll = () => {
      if (normalHeaderRef.current) {
        const threshold = normalHeaderRef.current.offsetHeight;
        setStickyVisible(window.scrollY > threshold);
      }
    };

    // 初回チェック
    handleScroll();

    window.addEventListener("scroll", handleScroll);
    window.addEventListener("resize", handleScroll);
    return () => {
      window.removeEventListener("scroll", handleScroll);
      window.removeEventListener("resize", handleScroll);
    };
  }, []);

  return (
    <>
      {/* 通常ヘッダー */}
      <header ref={normalHeaderRef} className="bg-[#f5f5f5] py-[20px]">
        <div className="mx-auto flex w-[90%] max-w-[1200px] items-center justify-between rounded-[10px] bg-white px-[25px] py-[15px] transition-all duration-300">
          <div className="text-[20px] font-bold text-[#333]">
            実験動物施設性能診断ツール
          </div>
          <div className="flex">
            <a
              href="#"
              className="ml-[25px] font-medium text-[#555] transition-colors duration-300 hover:text-[#164e63]"
            >
              ホーム
            </a>
            <a
              href="#"
              className="ml-[25px] font-medium text-[#555] transition-colors duration-300 hover:text-[#164e63]"
            >
              性能診断
            </a>
            <a
              href="#"
              className="ml-[25px] font-medium text-[#555] transition-colors duration-300 hover:text-[#164e63]"
            >
              お問い合わせ
            </a>
          </div>
          <a
            href="#"
            className="rounded-[4px] bg-[#164e63] px-[20px] py-[10px] font-bold text-white transition-colors duration-300 hover:bg-[#0e3a4a]"
          >
            診断する
          </a>
        </div>
      </header>

      {/* スクロール時に表示するstickyヘッダー */}
      <header
        className={`fixed top-2 left-0 z-[1000] w-full transition-opacity duration-300 ${
          stickyVisible ? "opacity-100" : "opacity-0"
        }`}
      >
        {/* 背景色は付与せず、中央のコンテナにのみ白い背景を設定 */}
        <div className="mx-auto flex w-[90%] max-w-[1200px] items-center justify-between rounded-none bg-white px-[25px] py-[10px] shadow-[0_4px_10px_rgba(0,0,0,0.15)]">
          <div className="text-[20px] font-bold text-[#333]">
            実験動物施設性能診断ツール
          </div>
          <div className="flex">
            <a
              href="#"
              className="ml-[25px] font-medium text-[#555] transition-colors duration-300 hover:text-[#164e63]"
            >
              ホーム
            </a>
            <a
              href="#"
              className="ml-[25px] font-medium text-[#555] transition-colors duration-300 hover:text-[#164e63]"
            >
              性能診断
            </a>
            <a
              href="#"
              className="ml-[25px] font-medium text-[#555] transition-colors duration-300 hover:text-[#164e63]"
            >
              お問い合わせ
            </a>
          </div>
          <a
            href="#"
            className="rounded-[4px] bg-[#164e63] px-[20px] py-[10px] font-bold text-white transition-colors duration-300 hover:bg-[#0e3a4a]"
          >
            診断する
          </a>
        </div>
      </header>
    </>
  );
};

export default Header;
