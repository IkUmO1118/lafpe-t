import { useState, useEffect, useRef } from "react";
import { NavLink } from "react-router-dom";
import Button from "../components/Button";

function Header() {
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
      <header
        ref={normalHeaderRef}
        className="border-b border-neutral-300/50 bg-neutral-50"
      >
        <div className="mx-auto flex max-w-[1440px] flex-col items-center gap-6 py-5">
          <div className="text-2xl font-bold tracking-tight text-cyan-950">
            実験動物施設性能診断ツール(試)
          </div>
          <li className="flex items-center gap-10">
            <NavLink
              to="home"
              className="text-sm text-neutral-700 hover:underline"
            >
              ホーム
            </NavLink>
            <NavLink
              to="diagnosis"
              className="text-sm text-neutral-700 hover:underline"
            >
              性能診断
            </NavLink>
            <NavLink
              to="contact"
              className="text-sm text-neutral-700 hover:underline"
            >
              ご意見・ご感想
            </NavLink>
            <Button
              as="link"
              type="primary"
              className="rounded-full px-5 py-2 text-sm font-bold"
            >
              診断する
            </Button>
          </li>
        </div>
      </header>

      {/* スクロール時に表示するstickyヘッダー */}
      <header
        className={`fixed left-0 z-[1000] block w-full transition-all duration-200 ${
          stickyVisible
            ? "pointer-events-auto top-2 translate-y-0 transform opacity-100"
            : "pointer-events-none top-2 -translate-y-full transform opacity-0"
        }`}
      >
        {/* 背景色は付与せず、中央のコンテナにのみ白い背景を設定 */}
        <div className="mx-auto flex w-10/12 max-w-[1440px] items-center justify-between rounded-full border border-neutral-300/50 bg-neutral-50 px-20 py-3 shadow-md">
          <div className="text-lg font-bold tracking-tight text-cyan-950">
            実験動物施設性能診断ツール(試)
          </div>
          <div className="flex items-center gap-12">
            <div className="flex gap-10">
              <NavLink
                to="home"
                className="text-sm text-neutral-800 hover:underline"
              >
                ホーム
              </NavLink>
              <NavLink
                to="diagnosis"
                className="text-sm text-neutral-800 hover:underline"
              >
                性能診断
              </NavLink>
              <NavLink
                to="contact"
                className="text-sm text-neutral-800 hover:underline"
              >
                ご意見・ご感想
              </NavLink>
            </div>
            <Button
              as="link"
              type="primary"
              className="cursor-pointer rounded-sm px-5 py-2 text-sm font-bold decoration-0 duration-75"
            >
              診断する
            </Button>
          </div>
        </div>
      </header>
    </>
  );
}

export default Header;
